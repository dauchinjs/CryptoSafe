<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BalanceTransactionsController
{
    public function index(): View
    {
        $types = ['', 'deposit', 'withdrawal', 'outgoing', 'incoming', 'transfers', 'transact'];
        $transactions = BalanceTransactions::where(function ($query) {
            if (Auth::id()) {
                $query->where('user_id', Auth::id());
            }
            if (request('user_name')) {
                $query->where('user_name', 'like', '%' . request('user_name') . '%');
            }
            if (request('account_number')) {
                $query->where('account_number', 'like', '%' . request('account_number') . '%');
            }
            if(request('type')) {
                if (request('type') == 'transfers') {
                    $query->whereIn('type', ['outgoing', 'incoming']);
                } else if (request('type') == 'transact') {
                    $query->whereIn('type', ['deposit', 'withdrawal']);
                } else {
                    $query->where('type', request('type'));
                }
            }
            if (request('date_from') && request('date_to')) {
                $dateFrom = Carbon::parse(request('date_from'));
                $dateTo = Carbon::parse(request('date_to'));
                if ($dateFrom->diffInYears($dateTo) <= 1) {
                    $query->whereDate('created_at', '>=', request('date_from'))
                        ->whereDate('created_at', '<=', request('date_to'));
                }
            }
        })->latest()->get();

        return view('transactions.balance', [
            'types' => $types,
            'transactions' => $transactions,
        ]);
    }
}
