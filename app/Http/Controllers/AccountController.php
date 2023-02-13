<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        $currencies = $this->getCurrencies();

        return view('accounts.accounts', [
            'accounts' => $accounts,
            'currencies' => $currencies
        ]);
    }

    public function edit(Account $account): View
    {
        if($account->user_id != Auth::id()) {
            abort(403);
        }
        $accounts = Account::where('user_id', Auth::id())->get();

        return view('accounts.edit', [
            $accounts
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $number = $request->get('number');
        $matchingAccount = Account::where('number', $number)->first();
        if (!$matchingAccount || $matchingAccount->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Account not found');
        }
        $name = $request->get('name');
        $matchingAccount->update([
            'name' => $name,
        ]);

        return redirect()->back()->with('success', 'Account updated.');
    }

    public function store(Request $request): RedirectResponse
    {
        $currency = strtoupper($request->get('currency'));
        $name = $request->get('name');

        $user = User::get()->first();

        $account = (new Account())->fill([
            'number' => 'LV' . rand(10, 99) . 'HEHE' . rand(100000000, 999999999),
            'balance' => 0,
            'currency' => $currency,
            'name' => $name,
        ]);
        $account->user()->associate($user);
        $account->save();

        return redirect()->back()->with('success', 'Account created.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $account = Account::where('number', $request->get('account_number'))->first();

        if ($account === null) {
            return redirect()->back()->with('error', 'Account not found.');
        }
        if($account->user_id != Auth::id()) {
            abort(403);
        }
        if($account->balance !== 0) {
            return redirect()->back()->with('error', 'Account balance must be 0 to delete.');
        }
        $account->delete();
        return redirect()->back()->with('success', 'Account deleted.');
    }

    private function getCurrencies(): array
    {
        $xml = simplexml_load_string(file_get_contents('https://www.bank.lv/vk/xml.xml?date=20131231'));
        $currencies = $xml->Currencies->Currency;
        $ids = array();
        foreach ($currencies as $currency) {
            $ids[] = $currency->ID;
        }
        return $ids;
    }
}
