<nav x-data="{ open: false }" class="border-b border-blue-600">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="w-20 h-20 fill-current"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-nav-link :href="route('crypto')"
                                :active="request()->routeIs('crypto') || request()->routeIs('crypto.search') || request()->routeIs('crypto.show')">
                        {{ __('Crypto') }}
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button>
                                <x-nav-link
                                    :active="request()->routeIs('accounts') || request()->routeIs('accounts.edit')">
                                    {{ __('Accounts') }}
                                </x-nav-link>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="GET" action="{{ route('accounts') }}">
                                @csrf

                                <x-dropdown-link :href="route('accounts')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('My Accounts') }}
                                </x-dropdown-link>
                            </form>

                            <form method="GET" action="{{ route('accounts.edit', $accounts[0]) }}">
                                @csrf
                                <x-dropdown-link :href="route('accounts.edit', $accounts[0])"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Edit Accounts') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button>
                                <x-nav-link
                                    :active="request()->routeIs('transfer.balance')">
                                    {{ __('Transfer') }}
                                </x-nav-link>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="GET" action="{{ route('transfer.balance') }}">
                                @csrf
                                <x-dropdown-link :href="route('transfer.balance')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Balance') }}
                                </x-dropdown-link>
                            </form>

                            <form method="GET" action="{{ route('transfer.crypto') }}">
                                @csrf
                                <x-dropdown-link :href="route('transfer.crypto')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Crypto') }}
                                </x-dropdown-link>
                            </form>

                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button>
                                <x-nav-link
                                    :active="request()->routeIs('transactions.balance')">
                                    {{ __('Transactions') }}
                                </x-nav-link>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="GET" action="{{ route('transactions.balance') }}">
                                @csrf
                                <x-dropdown-link :href="route('transactions.balance')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Account activity') }}
                                </x-dropdown-link>
                            </form>

                            <form method="GET" action="{{ route('transactions.crypto') }}">
                                @csrf
                                <x-dropdown-link :href="route('transactions.crypto')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Crypto movements') }}
                                </x-dropdown-link>
                            </form>

                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-200 hover:text-white hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="GET" action="{{ route('wallet') }}">
                            @csrf
                            <x-dropdown-link :href="route('wallet')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Wallet') }}
                            </x-dropdown-link>
                        </form>

                        <form method="GET" action="{{ route('codeCard') }}">
                            @csrf
                            <x-dropdown-link :href="route('codeCard')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Code Card') }}
                            </x-dropdown-link>
                        </form>

                        <form method="GET" action="{{ route('cryptocurrencies') }}">
                            @csrf
                            <x-dropdown-link :href="route('cryptocurrencies')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cryptocurrencies') }}
                            </x-dropdown-link>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="font-semibold">
                            @csrf

                            <x-dropdown-link :href="route('logout') " class="text-red-600"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
