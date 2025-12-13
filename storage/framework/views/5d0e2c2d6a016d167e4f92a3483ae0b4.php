<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'current' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['route', 'current' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isActive = $current === $route || str_starts_with($current, $route . '.');
?>

<a href="<?php echo e(route($route)); ?>"
   class="
        flex items-center px-4 py-2 rounded-lg transition font-medium
        <?php echo e($isActive 
            ? 'bg-green-600 text-white shadow-sm' 
            : 'text-green-800 hover:bg-green-100 hover:text-green-900'); ?>

   ">
    <span class="mr-3"><?php echo e($slot); ?></span>
</a>
<?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/components/nav/link.blade.php ENDPATH**/ ?>