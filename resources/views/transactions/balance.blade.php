<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Account activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <form method="GET" action="/transactions/balance">
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"
                                   for="user_name">User name:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"
                                       name="user_name" id="user_name">
                            </label>
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/5 mr-1"
                                   for="account_number">Account:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"
                                       name="account_number" id="account_number" placeholder="LVXXHEHEXXXXXXXXX">
                            </label>
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"
                                   for="type">By Type:
                                <select class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm"
                                        type="text"
                                        name="type" id="type">
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"
                                   for="date_from">Date from:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="date"
                                       name="date_from" id="date_from" max="{{ now()->subYear()->format('Y-m-d') }}"
                                       value="{{ now()->subYear()->format('Y-m-d') }}">
                            </label>
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"
                                   for="date_to">Date to:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="date"
                                       name="date_to" id="date_to" max="{{ now()->format('Y-m-d') }}"
                                       value="{{ now()->format('Y-m-d') }}">
                            </label>
                            <x-button class="mb-10 mt-7">
                                {{ __('Search') }}
                            </x-button>
                        </form>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Date
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Time
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">
                                Account
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Type
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">
                                Counterparty
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Amount
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="@if($transaction->type == 'outgoing' || $transaction->type == 'withdrawal') text-red-600
                            @elseif($transaction->type == 'incoming' || $transaction->type == 'deposit') text-green-600 @endif">
                                <td class="border px-1 py-1 text-center">{{ $transaction->dateFormatted }}</td>
                                <td class="border px-1 py-1 text-center">{{ $transaction->timeFormatted }}</td>
                                <td class="border px-1 py-1 text-center">{{ $transaction->account_number }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaction->type }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaction->user_name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaction->amountFormatted }} {{ $transaction->currency }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
