<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight">
            {{ __('Code Card') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-4 lg:px-10 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
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
