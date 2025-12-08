@props(['label', 'value', 'full' => false, 'bold' => false])

<div class="{{ $full ? 'col-span-2' : '' }}">
    <p class="text-sm text-gray-400">{{ $label }}</p>
    <div class="mt-1 px-4 py-2 rounded-lg border border-gray-200 {{ $bold ? 'font-semibold text-gray-900' : 'text-gray-700 bg-gray-50' }}">
        {{ $value }}
    </div>
</div>
