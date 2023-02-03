<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-bold text-xl leading-tight">
                {{ __('Crypto movements') }}
            </h2>
            {{--            <x-button id="toggle-button" onclick="showBuySell()">--}}
            {{--                {{ __('Show Transfer') }}--}}
            {{--            </x-button>--}}
        </div>
    </x-slot>

    <div id="buy-sell" style="display:block;" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{--                    <h2 class="text-center text-yellow-400 text-xl font-semibold">Buy & Sell transactions</h2>--}}
                    <div class="text-center">
                        <form method="GET" action="/transactions/crypto">
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/5 mr-1"
                                   for="account_number">Account:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"
                                       name="account_number" id="account_number" placeholder="LVXXHEHEXXXXXXXXX">
                            </label>
                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"
                                   for="user_name">By Symbol:
                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"
                                       name="symbol" id="symbol">
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

                    <div>
                        <h2 class="text-right text-l font-semibold mb-2">Total profit:
                            <span class="text-green-500" style="color: #00C853"
                                  @if($totalProfitFormatted < 0) style="color: #ff4444" @endif>€{{ $totalProfitFormatted }}</span>
                        </h2>
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
                            @if($searchType !== 'trade' && $searchType !== 'bought' && $searchType !== 'sold')
                                <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">
                                    Counterparty
                                </th>
                            @endif
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Crypto
                            </th>
                            <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">Amount
                            </th>
                            @if($searchType !== 'transfers' && $searchType !== 'incoming' && $searchType !== 'outgoing')
                                <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">
                                    Price
                                </th>
                                <th class="text-s border border-gold font-semibold text-gray-700 p-2 bg-yellow-300">
                                    Profit
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="border px-1 py-1 text-center">{{ $transaction->dateFormatted }}</td>
                                <td class="border px-1 py-1 text-center">{{ $transaction->timeFormatted }}</td>
                                <td class="border px-1 py-1 text-center">{{ $transaction->account_number }}</td>
                                @if($transaction->type == 'bought' || $transaction->type == 'incoming')
                                    <td class="border px-1 py-1 text-center text-green-500">{{ $transaction->type }}</td>
                                @else
                                    <td class="border px-1 py-1 text-center text-red-500">{{ $transaction->type }}</td>
                                @endif
                                @if($searchType !== 'trade' && $searchType !== 'bought' && $searchType !== 'sold')
                                    <td class="border px-1 py-1 text-center">{{ $transaction->user_name }}</td>
                                @endif
                                <td class="border px-4 py-2 text-center">{{ $transaction->symbol }}</td>
                                <td class="border px-4 py-2 text-center">{{ $transaction->amount }}</td>
                                @if($searchType !== 'transfers' && $searchType !== 'incoming' && $searchType !== 'outgoing')
                                    @if($transaction->price == null)
                                        <td class="border px-4 py-2 text-center"></td>
                                    @else
                                        <td class="border px-4 py-2 text-center">
                                            € {{ $transaction->priceFormatted }}</td>
                                    @endif
                                    @if($transaction->profit > 0)
                                        <td class="border px-4 py-2 text-center text-green-500">{{ $transaction->profitFormatted }}</td>
                                    @elseif($transaction->profit < 0)
                                        <td class="border px-4 py-2 text-center text-red-500">{{ $transaction->profitFormatted }}</td>
                                    @else
                                        <td class="border px-4 py-2 text-center"></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--    <div id="transfer" style="display:none;" class="py-12">--}}
    {{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
    {{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
    {{--                <div class="p-6 bg-white border-b border-gray-200">--}}
    {{--                    <h2 class="text-center text-yellow-400 text-xl font-semibold">Crypto transfer transactions</h2>--}}
    {{--                    <div class="text-center">--}}
    {{--                        <form method="GET" action="/transactions/crypto">--}}
    {{--                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/5 mr-1"--}}
    {{--                                   for="account_number">Account:--}}
    {{--                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"--}}
    {{--                                       name="account_number" id="account_number" placeholder="LVXXHEHEXXXXXXXXX">--}}
    {{--                            </label>--}}
    {{--                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"--}}
    {{--                                   for="user_name">By Symbol:--}}
    {{--                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"--}}
    {{--                                       name="symbol" id="symbol">--}}
    {{--                            </label>--}}
    {{--                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"--}}
    {{--                                   for="type">By Type:--}}
    {{--                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="text"--}}
    {{--                                       name="type" id="type">--}}
    {{--                            </label>--}}
    {{--                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"--}}
    {{--                                   for="date_from">Date from:--}}
    {{--                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="date"--}}
    {{--                                       name="date_from" id="date_from" max="{{ now()->subYear()->format('Y-m-d') }}"--}}
    {{--                                       value="{{ now()->subYear()->format('Y-m-d') }}">--}}
    {{--                            </label>--}}
    {{--                            <label class="inline-block uppercase mb-2 font-bold text-xs text-gray-700 w-1/6 mr-1"--}}
    {{--                                   for="date_to">Date to:--}}
    {{--                                <input class="inline-block w-4/5 border rounded border-gray-400 p-2 text-sm" type="date"--}}
    {{--                                       name="date_to" id="date_to" max="{{ now()->format('Y-m-d') }}"--}}
    {{--                                       value="{{ now()->format('Y-m-d') }}">--}}
    {{--                            </label>--}}
    {{--                            <x-button class="mb-10 mt-7">--}}
    {{--                                {{ __('Search') }}--}}
    {{--                            </x-button>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}

    {{--                    <table class="table-auto w-full">--}}
    {{--                        <thead>--}}
    {{--                        <tr>--}}
    {{--                            <th class="px-1 py-1">Date</th>--}}
    {{--                            <th class="px-4 py-2">Account</th>--}}
    {{--                            <th class="px-4 py-2">Type</th>--}}
    {{--                            <th class="px-4 py-2">Counterparty</th>--}}
    {{--                            <th class="px-4 py-2">Crypto</th>--}}
    {{--                            <th class="px-4 py-2">Amount</th>--}}
    {{--                        </tr>--}}
    {{--                        </thead>--}}
    {{--                        <tbody>--}}
    {{--                        @foreach ($transactions as $transaction)--}}
    {{--                            <tr @if($transaction->type == 'outgoing' || $transaction->type == 'incoming')>--}}
    {{--                                <td class="border px-1 py-1 text-center">{{ $transaction->created_at }}</td>--}}
    {{--                                <td class="border px-1 py-1 text-center">{{ $transaction->account_number }}</td>--}}
    {{--                                @if($transaction->type == 'incoming')--}}
    {{--                                    <td class="border px-1 py-1 text-center text-green-500">{{ $transaction->type }}</td>--}}
    {{--                                @else--}}
    {{--                                    <td class="border px-1 py-1 text-center text-red-500">{{ $transaction->type }}</td>--}}
    {{--                                @endif--}}
    {{--                                <td class="border px-1 py-1 text-center">{{ $transaction->user_name }}</td>--}}
    {{--                                <td class="border px-4 py-2 text-center">{{ $transaction->symbol }}</td>--}}
    {{--                                <td class="border px-4 py-2 text-center">{{ $transaction->amount }}</td>--}}
    {{--                                @endif--}}
    {{--                            </tr>--}}
    {{--                        @endforeach--}}
    {{--                        </tbody>--}}
    {{--                    </table>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <script>--}}
    {{--        function showBuySell() {--}}
    {{--            let buy_sell = document.getElementById("buy-sell");--}}
    {{--            let transfer = document.getElementById("transfer");--}}
    {{--            let button = document.getElementById("toggle-button");--}}
    {{--            if (buy_sell.style.display === "block") {--}}
    {{--                buy_sell.style.display = "none";--}}
    {{--                transfer.style.display = "block";--}}
    {{--                button.innerHTML = "Show Buy-Sell";--}}
    {{--            } else {--}}
    {{--                buy_sell.style.display = "block";--}}
    {{--                transfer.style.display = "none";--}}
    {{--                button.innerHTML = "Show Transfer";--}}
    {{--            }--}}
    {{--        }--}}
    {{--    </script>--}}
</x-app-layout>
