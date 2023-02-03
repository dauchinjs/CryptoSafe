<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyRequest;
use App\Models\Account;
use App\Models\BalanceTransactions;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WalletController
{
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('wallet', [
            'accounts' => $accounts,
        ]);
    }

    public function depositWithdraw(MoneyRequest $request): RedirectResponse
    {
        $account = Account::where('number', $request->get('account'))->firstOrFail();

        if ($account->user_id != Auth::id()) {
            abort(403);
        }
        $withdraw = $request->get('withdraw') * 100;
        $deposit = $request->get('deposit') * 100;

        $balance = $account->balance - $withdraw + $deposit;

        $account->update([
            'balance' => $balance,
        ]);

        $userId = $account->user_id;
        $user = User::where('id', $userId)->first();

        $transactionService = new TransactionService();

        if(!empty($withdraw)) {
            $transactionService->insertBalanceTransaction($account->number, $user->name, $withdraw, $account->currency, 'withdrawal', $user);
            return redirect()->back()->with('success', 'Withdrawal successful');
        }
        $transactionService->insertBalanceTransaction($account->number, $user->name, $deposit, $account->currency, 'deposit', $user);
        return redirect()->back()->with('success', 'Deposit successful');
    }
}
