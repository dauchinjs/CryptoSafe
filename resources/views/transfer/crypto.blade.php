<?php

use App\Models\Crypto;

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Transfer Crypto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Transfer Crypto</h2>
                    <form action="{{ route('transfer.crypto') }}" method="post">
                        @csrf

                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="from_account">Account
                                <select class="border rounded border-gray-400 p-2 w-full text-sm form-select"
                                        name="from_account"
                                        id="from_account"
                                >
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->number }}">
                                            {{ $account->name }} ({{ $account->number }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <div class="mb-6">
                                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="to_account"> To
                                    Account
                                    <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                           type="text"
                                           name="to_account"
                                           id="to_account"
                                           placeholder="LVXXHEHEXXXXXXXXX"
                                    >
                                </label>
                            </div>
                            @error('to_account')
                            <p class="text-red-500 text-s mb-1">Invalid account</p>
                            @enderror


                            <div class="mb-6">
                                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="number">Crypto
                                    Symbol
                                    <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                           type="text"
                                           name="symbol"
                                           id="symbol"
                                           placeholder="BTC"
                                    >
                                </label>
                            </div>

                            <div class="mb-6">
                                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="number">Amount
                                    <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                           type="text"
                                           name="amount"
                                           id="amount"
                                           placeholder="0.00"
                                    >
                                </label>
                            </div>
                            @error('amount')
                            <p class="text-red-500 text-s mb-1">Invalid amount</p>
                            @enderror

                            <div class="mb-6">
                                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password">Password
                                    <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                           type="password"
                                           name="password"
                                           id="password"
                                           placeholder="********"
                                    >
                                </label>
                                @error('password')
                                <p class="text-red-500 text-s mb-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-button>
                                    {{ __('Transfer') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-7">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-200 border-b border-gray-200">
                    <h2 class="text-left text-yellow-600 text-xl font-semibold mb-3">Owned Cryptocurrencies</h2>
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="text-xs border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Account Number</th>
                            <th class="text-xs border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Crypto</th>
                            <th class="text-xs border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cryptos as $crypto)
                            <tr class="@if($crypto->amount < 0) text-red-600
                            @elseif($crypto->amount > 0) text-green-600 @endif">
                                <td class="border px-1 py-1 text-center bg-white">{{ $crypto->account_number }}</td>
                                <td class="border px-1 py-1 text-center bg-white">{{ $crypto->symbol }}</td>
                                <td class="border px-4 py-2 text-center bg-white">{{ $crypto->amount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
