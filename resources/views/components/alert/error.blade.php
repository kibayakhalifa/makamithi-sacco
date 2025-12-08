<div {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800']) }}>
    <span class="text-red-600 font-semibold">✖</span>
    <div class="text-sm font-medium">
        {{ $slot }}
    </div>
</div>
