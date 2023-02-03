<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('My Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full text-left table-collapse">
                        <thead>
                        <tr>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Name</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Number</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Balance</th>
                            <th class="text-xs font-semibold text-gray-700 p-2 bg-yellow-300">Currency</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td class="p-2 border-t border-gray-200 font-medium text-gray-700">{{ $account->name }}</td>
                                <td class="p-2 border-t border-gray-200 font-medium text-gray-700">{{ $account->number }}</td>
                                <td class="p-2 border-t border-gray-200 font-medium text-gray-700">{{ $account->balanceFormatted }}</td>
                                <td class="p-2 border-t border-gray-200 font-medium text-gray-700">{{ $account->currency }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Create Account</h2>
                    <form action="{{ route('accounts.store') }}" method="post">
                        @csrf

                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name"> Account name
                                <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                       type="text"
                                       name="name"
                                       id="name"
                                       placeholder="My Account"
                                >
                            </label>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="currency">Currency</label>
                            <select class="border rounded border-gray-400 p-2 w-20 text-sm form-select"
                                    name="currency"
                                    id="currency"
                            >
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency }}">
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-button>
                            {{ __('Create') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Delete Account</h2>
                    <form action="{{ route('accounts.delete', $account->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="account_number"> Account number
                                <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                       type="text"
                                       name="account_number"
                                       id="account_number"
                                       placeholder="LVXXHEHEXXXXXXXXX"
                                       required
                                >
                            </label>
                        </div>
                        <x-button onclick="return confirm('Are you sure you want to delete this account?')">
                            {{ __('Delete') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
