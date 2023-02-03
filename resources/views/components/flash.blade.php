@if (session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         class="fixed bg-green-400 text-white py-2 px-4 rounded-xl top-0 right-3 text-sm mt-4">
        <p>{{ session('success') }}</p>
    </div>
@elseif (session()->has('error'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         class="fixed bg-red-400 text-white py-2 px-4 rounded-xl top-0 right-3 text-sm mt-4">
        <p>{{ session('error') }}</p>
    </div>
@elseif ($errors->any())
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 5000)"
         x-show="show"
         class="fixed bg-red-400 text-white py-2 px-4 rounded-xl top-0 right-3 text-sm mt-4">
        <p>Invalid transaction</p>
    </div>
@endif
