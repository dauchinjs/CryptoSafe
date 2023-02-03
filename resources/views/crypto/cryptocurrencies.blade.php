<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Owned cryptocurrencies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
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
