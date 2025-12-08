@props(['href' => '#'])

<a href="{{ $href }}"
   class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
    {{ $slot }}
</a>