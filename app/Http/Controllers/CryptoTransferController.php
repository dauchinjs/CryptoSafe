<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoTransferRequest;
use App\Models\Account;
use App\Models\Crypto;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CryptoTransferController extends Controller
{
    public function index(): View
    {
        $cryptos = Crypto::where('user_id', auth()->id())->get();
        return view('transfer.crypto', [
            'cryptos' => $cryptos
        ]);
    }

    public function transfer(CryptoTransferRequest $request): RedirectResponse
    {
        $fromAccount = Account::where('number', $request->get('from_account'))->firstOrFail();

        if ($fromAccount->user_id != Auth::id()) {
            abort(403);
        }

        $toAccount = Account::where('number', $request->get('to_account'))->firstOrFail();

        $amount = $request->get('amount');
        $symbol = $request->get('symbol');

        $fromUserId = $fromAccount->user_id;
        $toUserId = $toAccount->user_id;

        $fromUser = User::where('id', $fromUserId)->first();
        $toUser = User::where('id', $toUserId)->first();

        DB::transaction(function () use ($fromAccount, $toAccount, $amount, $symbol) {

            $fromAccountCrypto = Crypto::where('account_number', $fromAccount->number)->where('symbol', $symbol)->firstOrFail();
            $toAccountCrypto = Crypto::where('account_number', $toAccount->number)->where('symbol', $symbol)->first();

            if ($fromAccountCrypto->amount - $amount == 0) {
                $fromAccountCrypto->delete();
            } else {
                $fromAccountCrypto->amount -= $amount;
                $fromAccountCrypto->save();
            }

            if ($toAccountCrypto) {
                $toAccountCrypto->price = ($fromAccountCrypto->price * $amount + $toAccountCrypto->price * $toAccountCrypto->amount) / ($toAccountCrypto->amount + $amount);
                $toAccountCrypto->amount += $amount;
            } else {
                $toAccountCrypto = new Crypto();
                $toAccountCrypto->account_number = $toAccount->number;
                $toAccountCrypto->symbol = $symbol;
                $toAccountCrypto->price = $fromAccountCrypto->price;
                $toAccountCrypto->amount = $amount;
                $toAccountCrypto->user_id = $toAccount->user_id;
            }
            $toAccountCrypto->save();

        });
        $transactionService = new TransactionService();
        $transactionService->insertCryptoTransaction($fromAccount->number, $toUser->name, null, $amount, $symbol, null, 'outgoing', $fromUser);
        $transactionService->insertCryptoTransaction($toAccount->number, $fromUser->name, null, $amount, $symbol, null, 'incoming', $toUser);

        return redirect()->back()->with('success', 'Transfer successful');
    }
}
