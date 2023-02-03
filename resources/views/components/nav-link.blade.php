@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-xl font-medium leading-5 text-yellow-200 hover:text-yellow-300 focus:outline-none border-gold hover:border-yellow-600 transition duration-1000 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-l font-medium leading-5 text-yellow-100 hover:text-gray-200 hover:border-yellow-200 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
