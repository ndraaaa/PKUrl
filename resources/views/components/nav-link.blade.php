@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-4 py-2 mb-1 text-sm font-medium text-white bg-indigo-600 rounded-md transition duration-150 ease-in-out shadow-sm' 
            : 'flex items-center w-full px-4 py-2 mb-1 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>