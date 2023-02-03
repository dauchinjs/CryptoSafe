<?php

namespace App\Http\Controllers;

use App\Models\CryptoTransactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoTransactionsController
{
    public function index(): View
    {
        $types = ['', 'bought', 'sold', 'incoming', 'outgoing', 'transfers', 'trade'];

        $totalProfit = CryptoTransactions::where('user_id', Auth::id())->get()->sum('profit');
        $totalProfitFormatted = number_format($totalProfit / 100, 2);

        $searchType = request('type');

        $transactions = CryptoTransactions::where(function ($query) {
            if (Auth::id()) {
                $query->where('user_id', Auth::id());
            }
            if (request('account_number')) {
                $query->where('account_number', 'like', '%' . request('account_number') . '%');
            }
            if (request('user_name')) {
                $query->where('user_name', 'like', '%' . request('user_name') . '%');
            }
            if (request('type')) {
                if (request('type') == 'transfers') {
                    $query->whereIn('type', ['outgoing', 'incoming']);
                } else if (request('type') == 'trade') {
                    $query->whereIn('type', ['bought', 'sold']);
                } else {
                    $query->where('type', request('type'));
                }
            }
            if (request('symbol')) {
                $query->where('symbol', 'like', '%' . request('symbol') . '%');
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

        return view('transactions.crypto', [
            'types' => $types,
            'totalProfitFormatted' => $totalProfitFormatted,
            'transactions' => $transactions,
            'searchType' => $searchType
        ]);
    }
}
