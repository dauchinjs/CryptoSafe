<?php

namespace App\Http\Controllers;


use App\Http\Requests\BuySellRequest;
use App\Models\Account;
use App\Models\Crypto;
use App\Models\User;
use App\Services\CryptoService;
use App\Services\CurrencyConversionService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CryptoController
{
    private CryptoService $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function index()
    {
        $coinsList = $this->cryptoService->getCryptoList();

        return view('crypto.coins',
            [
                'coins' => $coinsList
            ]
        );
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $cryptoId = $this->cryptoService->getCryptoIdBySlug($search);

        if ($cryptoId != null) {
            $coin = $this->cryptoService->getCryptoById($cryptoId);
            return view('crypto.show',
                [
                    'coin' => $coin
                ]
            );
        }
        $coin = $this->cryptoService->getCryptoBySymbol($search);

        return view('crypto.show',
            [
                'coin' => $coin[0]
            ]
        );
    }

    public function show(int $id)
    {
        $coin = $this->cryptoService->getCryptoById($id);

        $myCryptos = Crypto::where('symbol', $coin['symbol'])->where('user_id', Auth::id())->get();
//        var_dump($myCryptos);die;

        return view('crypto.show',
            [
                'coin' => $coin,
                'myCryptos' => $myCryptos
            ]
        );
    }

    public function buySell(int $id, BuySellRequest $request): RedirectResponse
    {
        $account = Account::where('number', $request->get('account'))->firstOrFail();
        $coin = $this->cryptoService->getCryptoById($id);
        $userId = $account->user_id;

        $user = User::where('id', $userId)->first();
        $cryptos = Crypto::where('account_number', $account->number)->where('symbol', $coin['symbol'])->get();

        if ($request->get('buy') != null) {
            $amount = $request->get('buy');
        } else {
            $amount = $request->get('sell');
        }

        $price = $coin['quote']['EUR']['price'] * 100;
        $totalPrice = $price * $amount;

        if ($request->get('buy') != null) {
            if ($totalPrice > $account->balance && json_decode($cryptos)[0]->amount >= 0) {
                return redirect()->back()->with('error', 'Not enough money');
            }
        }

        $cryptoCurrency = 'EUR';
        $accountCurrency = $account->currency;
        $currencyConversionService = new CurrencyConversionService();

        if ($accountCurrency != $cryptoCurrency) {
            $currencyConversion = $currencyConversionService->getCurrencyConversion($cryptoCurrency, $accountCurrency, $price);
            $convertedPrice = $currencyConversion['result'];
        } else {
            $convertedPrice = $price;
        }


        if ($cryptos->count() == 0) {
            $ownedAmount = 0;
            $ownedPrice = 0;
            $averagePrice = $convertedPrice;
        } else {
            $ownedAmount = json_decode($cryptos)[0]->amount;
            $ownedPrice = json_decode($cryptos)[0]->price;
            if ($ownedAmount + $amount == 0) {
                $averagePrice = $convertedPrice * $amount;
            } else {
                $averagePrice = ($ownedPrice * $ownedAmount + $convertedPrice * $amount) / ($ownedAmount + $amount);
            }
        }

        $transactionService = new TransactionService();

        if ($request->get('buy') != null) {
            DB::transaction(function () use ($account, $convertedPrice, $amount) {
                $account->update([
                    'balance' => $account->balance - $convertedPrice * $amount,
                ]);
            });

            if ($ownedAmount < 0) {
                $shortProfit = $ownedPrice * $amount - $convertedPrice * $amount;
            } else {
                $shortProfit = 0;
            }
            $this->cryptoService->saveCrypto($account->number, $coin['symbol'], $averagePrice, $ownedAmount + $amount, $user);
            $transactionService->insertCryptoTransaction($account->number, null, $price, $amount, $coin['symbol'], $shortProfit, 'bought', $user);

            return redirect()->back()->with('success', 'You bought ' . $amount . ' ' . $coin['symbol'] . ' for ' . number_format($convertedPrice / 100, 2) . ' ' . $accountCurrency);
        }
        if ($request->get('sell') != null) {
            DB::transaction(function () use ($account, $convertedPrice, $amount) {
                $account->update([
                    'balance' => $account->balance + $convertedPrice * $amount,
                ]);
            });
            if ($ownedAmount <= 0) {
                $longProfit = 0;
            } else {
                $longProfit = $convertedPrice * $amount - $ownedPrice * $amount;
            }
            $this->cryptoService->saveCrypto($account->number, $coin['symbol'], $averagePrice, $ownedAmount - $amount, $user);
            $transactionService->insertCryptoTransaction($account->number, null, $price, $amount, $coin['symbol'], $longProfit, 'sold', $user);

            return redirect()->back()->with('success', 'You sold ' . $amount . ' ' . $coin['symbol'] . ' for ' . number_format($convertedPrice / 100, 2) . ' ' . $accountCurrency);
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }
}
