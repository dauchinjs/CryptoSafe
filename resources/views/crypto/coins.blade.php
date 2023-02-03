<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Crypto Safe') }}
        </h2>
    </x-slot>


    <div class="text-right font-semibold text-xl text-gray-800 leading-tight mr-10 mt-3">
        <form action="{{ route('crypto.search', $coins[0])  }}" method="get">
            @csrf
            <label for="search" class="text-sm text-gray-700"></label>
            <div class="relative rounded-md">
                <input type="text" name="search" id="search" placeholder="e.g. BTC"
                       class="form-input py-2 px-3 rounded-md font-medium text-gray-700">
                <x-button>
                    {{ __('Search') }}
                </x-button>
            </div>
        </form>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-200 border-b border-gray-200">
                    <table class="w-full text-left table-collapse">
                        <thead>
                        <tr>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">#</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Name</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Price</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">1h %</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">24h %</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">7d %</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Market Cap<span
                                    class="hoverText sm:px-1 lg:px-2"
                                    data-hover="The total market value of a cryptocurrency's circulating supply.
                                     It is analogous to the free-float capitalization in the stock market.
                                Market Cap = Current Price x Circulating Supply.
                                ">&#9432</span>
                            </th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Circulating supply<span
                                    class="hoverText sm:px-1 lg:px-2"
                                    data-hover="The amount of coins that are circulating in the market and are in public hands.
                                     It is analogous to the flowing shares in the stock market.">&#9432</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coins as $coin)
                            <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-yellow-100 dark:hover:bg-gray-600">
                                <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                    {{array_search($coin, $coins) + 1}}
                                </td>
                                <th scope="row"
                                    class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                    <a href="/crypto/{{$coin['id']}}">
                                        <img class="object-scale-down h-6 w-6 inline-block"
                                             src="https://s2.coinmarketcap.com/static/img/coins/200x200/{{$coin['id']}}.png"
                                             alt="Symbol"
                                             onerror=this.src="https://s2.coinmarketcap.com/static/img/coins/64x64/{{$coin['id']}}.png">
                                        {{$coin['name']}} <span class="text-gray-500">{{$coin['symbol']}} </span>
                                    </a>
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
                                <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                    € {{number_format($coin['quote']['EUR']['market_cap'], 2)}}
                                </td>
                                <td class="p-3 border-t border-gray-200 font-medium text-gray-700">
                                    {{number_format($coin['circulating_supply'], 2)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
