<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Crypto Safe') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full text-left table-collapse">
                        <thead>
                        <tr>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Name</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Price</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">1h %</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">24h %</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">7d %</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                <img class="object-scale-down h-6 w-6 inline-block"
                                     src="https://s2.coinmarketcap.com/static/img/coins/200x200/{{$coin['id']}}.png"
                                     alt="Symbol"
                                     onerror=this.src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{$coin['id']}}.png">
                                {{$coin['name']}} <span class="text-gray-500">{{$coin['symbol']}} </span>
                            </th>
                            <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                € {{number_format($coin['quote']['EUR']['price'], 2)}}
                            </td>
                            @if($coin['quote']['EUR']['percent_change_1h'] > 0.00)
                                <td class="p-3 border-t border-gray-200 font-medium text-green-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_1h'], 2)}}%
                                </td>
                            @else
                                <td class="p-3 border-t border-gray-200 font-medium text-red-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_1h'], 2)}}%
                                </td>
                            @endif
                            @if($coin['quote']['EUR']['percent_change_24h'] > 0)
                                <td class="p-3 border-t border-gray-200 font-medium text-green-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_24h'], 2)}}%
                                </td>
                            @else
                                <td class="p-3 border-t border-gray-200 font-medium text-red-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_24h'], 2)}}%
                                </td>
                            @endif
                            @if($coin['quote']['EUR']['percent_change_7d'] > 0)
                                <td class="p-3 border-t border-gray-200 font-medium text-green-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_7d'], 2)}}%
                                </td>
                            @else
                                <td class="p-3 border-t border-gray-200 font-medium text-red-600">
                                    {{number_format($coin['quote']['EUR']['percent_change_7d'], 2)}}%
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="buy-sell-container">
        @if($myCryptos->isEmpty())

        @else
            <div class="mr-10">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">{{ $coin['name'] }} owned</h2>
                        <table class="text-left table-collapse">
                            <thead>
                            <tr>
                                <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Account</th>
                                <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myCryptos as $crypto)
                                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                    <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                        {{ $crypto->account_number }}
                                    </td>
                                    <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                        {{ $crypto->amount }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Buy {{ $coin['name'] }}</h2>
                <form action="{{ route('crypto.buySell', $coin['id']) }}" method="post">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="account">Account
                            <select class="border rounded border-gray-400 p-2 w-full text-sm form-select"
                                    name="account"
                                    id="account"
                            >
                                @foreach($accounts as $account)
                                    <option value="{{ $account->number }}">
                                        {{ $account->name }} ({{ $account->number }})
                                        Balance: {{ $account->balanceFormatted }}
                                        {{ $account->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="buy">Amount
                            <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                   type="text"
                                   name="buy"
                                   id="buy"
                                   placeholder="0.00"
                            >
                        </label>
                    </div>
                    <x-button>
                        {{ __('Buy') }}
                    </x-button>
                </form>

                <hr class="mt-4 mb-4 border-yellow-300">

                <h2 class="text-xl font-bold text-gray-800 mb-6">Sell {{ $coin['name'] }}</h2>
                <form action="{{ route('crypto.buySell', $coin['id']) }}" method="post">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="account">Account
                            <select class="border rounded border-gray-400 p-2 w-full text-sm form-select"
                                    name="account"
                                    id="account"
                            >
                                @foreach($accounts as $account)
                                    <option value="{{ $account->number }}">
                                        {{ $account->name }} ({{ $account->number }})
                                        Balance: {{ $account->balanceFormatted }}
                                        {{ $account->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="sell">Amount
                            <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                   type="text"
                                   name="sell"
                                   id="sell"
                                   placeholder="0.00"
                            >
                        </label>
                    </div>
                    <x-button>
                        {{ __('Sell') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .buy-sell-container {
        display: flex;
        justify-content: center;
    }
</style>
