<x-app-layout>
    <x-slot name="header" class="bg-gray-300">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Edit Accounts') }}
        </h2>
        @foreach($accounts as $account)
            <div class="mt-2 my-1 font-semibold">
                @if($account->name)
                    {{ $account->name }} <small>({{ $account->number }})</small>
                @else
                    <small>{{ $account->number }}</small>
                @endif
            </div>
        @endforeach
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Update Account</h2>
                    <form action="{{ route('accounts.update', $accounts[0])  }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="number">Which
                                account
                                <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                       type="text"
                                       name="number"
                                       id="number"
                                       placeholder="LVXXHEHEXXXXXXXXX"
                                       required
                                >
                            </label>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="number"> New Account
                                name
                                <input class="border rounded border-gray-400 p-2 w-full text-sm"
                                       type="text"
                                       name="name"
                                       id="name"
                                       placeholder="My Account"
                                >
                            </label>
                        </div>
                        <div class="mb-6">
                            <x-button>
                                {{ __('Update') }}
                            </x-button>
{{--                            <button type="submit"--}}
{{--                                    class="bg-gray-100 border text-black rounded py-2 px-4 hover:bg-blue-300">--}}
{{--                                Update--}}
{{--                            </button>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
