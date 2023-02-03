<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceTransactionsController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\CodeCardController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\CryptoTransactionsController;
use App\Http\Controllers\CryptoTransferController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::get('/accounts', [AccountController::class, 'index'])->middleware(['auth'])->name('accounts');
Route::post('/accounts', [AccountController::class, 'store'])->middleware(['auth'])->name('accounts.store');
Route::delete('/accounts/{account}', [AccountController::class, 'destroy'])->middleware(['auth'])->name('accounts.delete');
Route::get('/accounts/{account}/edit', [AccountController::class, 'edit'])->middleware(['auth'])->name('accounts.edit');
Route::put('/accounts/{account}', [AccountController::class, 'update'])->middleware(['auth'])->name('accounts.update');

Route::get('/wallet', [WalletController::class, 'index'])->middleware(['auth'])->name('wallet');
Route::post('/wallet', [WalletController::class, 'depositWithdraw'])->middleware(['auth'])->name('wallet.depositWithdraw');

Route::get('/transfer/balance', [BalanceTransferController::class, 'index'])->middleware(['auth'])->name('transfer.balance');
Route::post('/transfer/balance', [BalanceTransferController::class, 'transfer'])->middleware(['auth'])->name('transfer.balance');

Route::get('/transfer/crypto', [CryptoTransferController::class, 'index'])->middleware(['auth'])->name('transfer.crypto');
Route::post('/transfer/crypto', [CryptoTransferController::class, 'transfer'])->middleware(['auth'])->name('transfer.crypto');

Route::get('/transactions/balance', [BalanceTransactionsController::class, 'index'])->middleware(['auth'])->name('transactions.balance');
Route::get('/transactions/crypto', [CryptoTransactionsController::class, 'index'])->middleware(['auth'])->name('transactions.crypto');

Route::get('/crypto', [CryptoController::class, 'index'])->middleware(['auth'])->name('crypto');
Route::get('/crypto/search', [CryptoController::class, 'search'])->middleware(['auth'])->name('crypto.search');
Route::get('/crypto/{id}', [CryptoController::class, 'show'])->middleware(['auth'])->name('crypto.show');
Route::post('/crypto/{id}/buy-sell', [CryptoController::class, 'buySell'])->middleware(['auth'])->name('crypto.buySell');

Route::get('/codeCard', [CodeCardController::class, 'index'])->middleware(['auth'])->name('codeCard');

Route::get('/cryptocurrencies', function () {
    return view('crypto.cryptocurrencies');
})->middleware(['auth'])->name('cryptocurrencies');

require __DIR__.'/auth.php';
