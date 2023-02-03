<?php

namespace App\Http\Requests;

use App\Services\CryptoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BuySellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'account' => [
                'required',
                'exists:accounts,number',
            ],
            'buy' => Rule::requiredIf(function () {
                return !$this->input('sell');
            }),
            'sell' => Rule::requiredIf(function () {
                return !$this->input('buy');
            }),
        ];
    }
}
