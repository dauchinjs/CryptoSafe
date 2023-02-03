<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class BalanceTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(Request $request): array
    {
        $fromAccount = Account::where('number', $request->get('from_account'))->firstOrFail();

        $password = $request->get('password');
        if (!Hash::check($password, $fromAccount->user->password)) {
            return [
                'password' => [
                    'required',
                    'password',
                ],
            ];
        }

        return [
            'from_account' => [
                'required',
                'exists:accounts,number',
            ],
            'to_account' => [
                'required',
                'exists:accounts,number',
                'different:from_account',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $fromAccount->balance / 100,
            ],
        ];
    }
}
