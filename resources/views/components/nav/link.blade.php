@props(['route', 'current' => ''])

@php
    $isActive = $current === $route || str_starts_with($current, $route . '.');
@endphp

<a href="{{ route($route) }}"
   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition
          {{ $isActive ? 'bg-gray-500 text-gray-900 font-medium' : '' }}">
    {{ $slot }}
</a>