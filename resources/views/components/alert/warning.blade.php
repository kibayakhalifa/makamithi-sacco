<div id="warning-alert" {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-800']) }}>
    <span class="text-yellow-600 font-semibold">⚠</span>
    <div class="text-sm font-medium">
        {{ $slot }}
    </div>
</div>