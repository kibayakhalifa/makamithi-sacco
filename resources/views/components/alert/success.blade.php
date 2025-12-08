<div {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800']) }}>
    <span class="text-green-600 font-semibold">✔</span>
    <div class="text-sm font-medium">
        {{ $slot }}
    </div>
</div>
