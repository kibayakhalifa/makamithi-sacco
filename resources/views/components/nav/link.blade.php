@props(['route', 'current' => ''])

@php
    $isActive = $current === $route || str_starts_with($current, $route . '.');
@endphp

<a href="{{ route($route) }}"
   class="
        flex items-center px-4 py-2 rounded-lg transition font-medium
        {{ $isActive 
            ? 'bg-green-600 text-white shadow-sm' 
            : 'text-green-800 hover:bg-green-100 hover:text-green-900'
        }}
   ">
    <span class="mr-3">{{ $slot }}</span>
</a>
