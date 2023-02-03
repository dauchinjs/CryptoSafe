<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <section class="bg-gray-200 py-8 px-6" id="crypto">
                        <div class="flex">
                            <div class="w-3/4">
                                <h2 class="text-2xl font-semibold mb-4 text-yellow-500">Crypto</h2>
                                <p class="text-gray-700 mr-2">
                                    Discover the ultimate crypto destination on our website. Enjoy safe and secure
                                    buying, selling, short-selling, and transferring of various cryptocurrencies, all
                                    while seamlessly converting to EUR. Our platform offers state-of-the-art security,
                                    market analysis, and a user-friendly interface, making managing your crypto
                                    portfolio easy and convenient for users of any currency.
                                </p>
                            </div>
                            <div class="w-1/2">
                                <img src="{{ asset('images/home-crypto.png') }}" alt="image"
                                     class="shadow-md rounded-lg">
                            </div>
                        </div>
                    </section>

                    <section class="bg-gray-300 py-8 px-6" id="banking">
                        <div class="flex">
                            <div class="w-1/3">
                                <img src="{{ asset('images/home-banking.svg') }}" alt="image">
                            </div>
                            <div class="w-3/4">
                                <h2 class="text-2xl font-semibold mb-4 text-yellow-500 ml-2">Banking</h2>
                                <p class="text-gray-700 ml-2">
                                    Our platform allows you to easily transfer money to others, view your transactions,
                                    and access multiple currencies all in one place. Our state-of-the-art security
                                    ensures that your transactions are always safe and secure. With user-friendly
                                    interface, you can manage your account and make transactions on the go. Thanks to
                                    our extensive network and multiple currencies support, you can transfer money to
                                    anyone, anywhere in the world. Join us now and enjoy the convenience of online
                                    banking.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
