<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceTransferRequest;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\User;
use App\Services\CurrencyConversionService;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BalanceTransferController extends Controller
{
    private int $codeNumberId;

    public function __construct()
    {
        if (!session()->has('codeNumberId')) {
            $this->codeNumberId = rand(0, 9);
            session()->put('codeNumberId', $this->codeNumberId);
        } else {
            $this->codeNumberId = session()->get('codeNumberId');
        }
    }

    public function index(): View
    {
        $accounts = Account::where('user_id', Auth::id())->get();

        $this->codeNumberId = rand(0, 9);
        session()->put('codeNumberId', $this->codeNumberId);

        return view('transfer.balance', [
            'accounts' => $accounts,
            'codeNumberId' => $this->codeNumberId + 1,
        ]);
    }

    public function transfer(BalanceTransferRequest $request): RedirectResponse
    {
        $fromAccount = Account::where('number', $request->get('from_account'))->firstOrFail();

        if ($fromAccount->user_id != Auth::id()) {
            abort(403);
        }

        $codes = CodeCard::where('user_id', Auth::id())->get();

        $this->codeNumberId = session()->get('codeNumberId');
        $code = $codes[$this->codeNumberId]->code;

        $checkCode = $request->get('code_number');

        if ($code != $checkCode) {
            return redirect()->back()->with('error', 'Code is not correct');
        }

        $toAccount = Account::where('number', $request->get('to_account'))->firstOrFail();

        $amount = $request->get('amount') * 100;

        $fromCurrency = $fromAccount->currency;
        $toCurrency = $toAccount->currency;

        $currencyConversionService = new CurrencyConversionService();
        $currencyConversion = $currencyConversionService->getCurrencyConversion($fromCurrency, $toCurrency, $amount);
        $convertedAmount = $currencyConversion['result'];

        if ($fromAccount->currency != $toAccount->currency) {
            DB::transaction(function () use ($fromAccount, $toAccount, $amount, $convertedAmount) {
                $fromAccount->update([
                    'balance' => $fromAccount->balance - $amount,
                ]);
                $toAccount->update([
                    'balance' => $toAccount->balance + $convertedAmount,
                ]);
            });
        } else {
            DB::transaction(function () use ($fromAccount, $toAccount, $amount) {
                $fromAccount->update([
                    'balance' => $fromAccount->balance - $amount,
                ]);
                $toAccount->update([
                    'balance' => $toAccount->balance + $amount,
                ]);
            });
        }

        $fromUserId = $fromAccount->user_id;
        $toUserId = $toAccount->user_id;

        $fromUser = User::where('id', $fromUserId)->first();
        $toUser = User::where('id', $toUserId)->first();

        $transactionService = new TransactionService();

        $transactionService->insertBalanceTransaction($fromAccount->number, $toUser->name, $amount, $fromAccount->currency, 'outgoing', $fromUser);
        $transactionService->insertBalanceTransaction($toAccount->number, $fromUser->name, $convertedAmount, $toAccount->currency, 'incoming', $toUser);

        session()->forget('codeNumberId');
        return redirect()->back()->with('success', 'Transfer successful.');
    }
}
