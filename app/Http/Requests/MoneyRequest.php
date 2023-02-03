<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MoneyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $account = Account::where('number', $request->get('account'))->firstOrFail();

        if ($request->get('withdraw') > 0) {
            return [
                'withdraw' => [
                    'required',
                    'numeric',
                    'min:0.01',
                    'max:' . $account->balance / 100,
                ],
            ];
        }

        if ($request->get('deposit') > 0) {
            return [
                'deposit' => [
                    'required',
                    'numeric',
                    'min:0.01',
                ],
            ];
        }

        return [
            'account' => [
                'required',
                'exists:accounts,number',
            ],
        ];
    }
}
