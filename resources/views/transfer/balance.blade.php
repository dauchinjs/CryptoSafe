<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Transfer Balance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Transfer Money</h2>
                    <form action="{{ route('transfer.balance') }}" method="post">
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
                                            Balance: {{ $account->balanceFormatted }}
                                            {{ $account->currency }}
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
                                <p class="text-red-500 text-s mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="number">Code
                                    Number
                                    <span class="font-bold text-sm">{{ $codeNumberId }}</span>
                                    <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                           type="text"
                                           name="code_number"
                                           id="code_number"
                                           placeholder="XXXXXX"
                                    >
                                </label>
                                @error('code_number')
                                <p class="text-red-500 text-s mt-2">{{ $message }}</p>
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

    <div class="max-w-3xl mx-auto sm:px-4 lg:px-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Code Card</h2>
                <div class="flex flex-wrap -mx-2">
                    @foreach ($codes as $code)
                        <div class="w-1/5 px-2">
                            <div class="flex items-center p-2 border-t border-gray-200 font-medium text-gray-700">
                                <div class="w-1/2 font-bold">{{ $code->code_id }}</div>
                                <div class="w-1/2 font-bold">-</div>
                                <div class="w-1/2">{{ $code->code }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
