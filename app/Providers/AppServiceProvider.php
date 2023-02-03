<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Crypto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Account $account, CodeCard $codeCard, Crypto $cryptos)
    {
        View::composer('*', function ($view) use ($account, $codeCard, $cryptos) {
            $view->with('accounts', $account->where('user_id', Auth::id())->get());
            $view->with('codes', $codeCard->where('user_id', Auth::id())->get());
            $view->with('cryptos', $cryptos->where('user_id', Auth::id())->get());
        });
    }
}
