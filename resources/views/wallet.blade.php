<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4">
                        <form action="{{ route('wallet.depositWithdraw') }}" method="post">
                            @csrf

                            <div>
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

                            <h2 class="text-lg font-bold mb-4">Withdraw money</h2>
                            <div class="mb-6">
                                <label for="withdraw" class="mb-6">
                                    <input type="text" id="withdraw" name="withdraw"
                                           class="border py-2 px-3 w-full rounded-lg"
                                           placeholder="0.00">
                                </label>
                            </div>
                            <div class="mb-10">
                                <x-button>
                                    {{ __('Withdraw') }}
                                </x-button>
                            </div>

                            <h2 class="text-lg font-bold mb-4">Deposit money</h2>
                            <div class="mb-6">
                                <label for="deposit">
                                    <input type="text" id="deposit" name="deposit"
                                           class="border py-2 px-3 w-full rounded-lg"
                                           placeholder="0.00">
                                </label>
                            </div>
                            <div class="mb-6">
                                <x-button>
                                    {{ __('Deposit') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
