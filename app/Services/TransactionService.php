<?php

namespace App\Services;

use App\Models\BalanceTransactions;
use App\Models\CryptoTransactions;
use App\Models\User;

class TransactionService
{
    public function insertBalanceTransaction(string $accountNumber, string $name, float $amount, string $currency, string $type, User $user)
    {
        $transaction = (new BalanceTransactions())->fill([
            'account_number' => $accountNumber,
            'amount' => $amount,
            'currency' => $currency,
            'user_name' => $name,
            'type' => $type,
        ]);
        $transaction->user()->associate($user);
        $transaction->save();
    }

    public function insertCryptoTransaction(string $accountNumber, ?string $name, ?float $price, float $amount, string $symbol, ?float $profit, string $type,  User $user)
    {
        $transaction = (new CryptoTransactions())->fill([
            'account_number' => $accountNumber,
            'user_name' => $name,
            'price' => $price,
            'amount' => $amount,
            'symbol' => $symbol,
            'profit' => $profit,
            'type' => $type,
        ]);
        $transaction->user()->associate($user);
        $transaction->save();
    }
}
