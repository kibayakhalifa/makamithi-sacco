@props(['label', 'value', 'emphasis' => false])

<div class="flex justify-between items-center p-3 rounded-lg {{ $emphasis ? 'bg-gray-100 text-gray-900 font-semibold' : 'bg-gray-50 text-gray-700' }}">
    <span class="text-sm">{{ $label }}</span>
    <span>{{ $value }}</span>
</div>
