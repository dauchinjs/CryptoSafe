<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CodeCard;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $account = (new Account())->fill([
            'number' => 'LV' . rand(10, 99) . 'HEHE' . rand(100000000, 999999999),
            'balance' => 0,
            'currency' => 'EUR',
        ]);
        $account->user()->associate($user);
        $account->save();

        $numbers = [];
        for ($i = 0; $i < 10; $i++) {
            $numbers[] = rand(100000, 999999);
        }
        $cardId = 1;
        foreach ($numbers as $number) {
            $codeCard = (new CodeCard())->fill([
                'code_id' => $cardId,
                'code' => $number,
            ]);
            $codeCard->user()->associate($user);
            $codeCard->save();
            $cardId++;
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('success', 'Account created and logged in.');
    }
}
