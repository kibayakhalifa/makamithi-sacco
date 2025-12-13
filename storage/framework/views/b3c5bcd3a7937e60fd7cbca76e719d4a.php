<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Makamithi Sacco - <?php echo $__env->yieldContent('title'); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r hidden md:flex flex-col shadow-sm">

            <!-- Header -->
            <div class="p-6 border-b bg-green-50">
                <h1 class="text-2xl font-bold text-green-700 flex items-center gap-2">
                    <span class="w-2 h-6 bg-orange-500 rounded"></span>
                    Makamithi Sacco
                </h1>

                <p class="text-green-800 text-sm mt-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php echo e(ucfirst(auth()->user()->role)); ?> Panel
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userRole === 'member'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.savings.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.savings.index','current' => ''.e($current).'']); ?>💰 My Savings <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.apply','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.apply','current' => ''.e($current).'']); ?>📝 Apply Loan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.profile','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.profile','current' => ''.e($current).'']); ?>👤 My Profile <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.index','current' => ''.e($current).'']); ?>📜 My Loans <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'chairman'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.loan-approvals','current' => ''.e($current).'']); ?>✅ Loan Approvals <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.members','current' => ''.e($current).'']); ?>👥 Members <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'treasurer'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.dashboard','current' => ''.e($current).'']); ?>📊 Treasurer Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.payments','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.payments','current' => ''.e($current).'']); ?>💳 Payment Processing <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.loans','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.loans','current' => ''.e($current).'']); ?>📋 Loans Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.savings','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.savings','current' => ''.e($current).'']); ?>💰 Savings Summary <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.expenses','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.expenses','current' => ''.e($current).'']); ?>📊 Expenses Tracking <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.cheques','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.cheques','current' => ''.e($current).'']); ?>🏦 Cheque Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.reconciliation','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.reconciliation','current' => ''.e($current).'']); ?>✔️ Bank
                            Reconciliation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.financial-reports','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.financial-reports','current' => ''.e($current).'']); ?>📈 Financial
                            Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'secretary'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.loan-approvals','current' => ''.e($current).'']); ?>✅ Loan Approvals <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.members','current' => ''.e($current).'']); ?>👥 Member Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.communications','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.communications','current' => ''.e($current).'']); ?>📧 Communications <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.documents','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.documents','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- SETTINGS + LOGOUT -->
                    <div class="pt-6 mt-6 border-t border-green-200">
                        <a href="<?php echo e(route('settings')); ?>"
                            class="w-full block text-left px-4 py-2 text-green-700 hover:bg-green-100 rounded-lg">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white border-b px-6 py-4 flex justify-between items-center shadow-sm">

                <button id="menuToggle" class="md:hidden text-gray-700 text-2xl">☰</button>

                <div class="flex items-center space-x-3">
                    <div class="hidden md:block text-right">
                        <p class="font-medium text-green-800"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-green-600">
                            <?php echo e(ucfirst(auth()->user()->role)); ?> • <?php echo e(auth()->user()->employee_number ?? 'EMP001'); ?>

                        </p>
                    </div>

                    <div
                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <?php if (isset($component)) { $__componentOriginalf192f9e16cd34f43530f7484bbd899b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf192f9e16cd34f43530f7484bbd899b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.success','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(session('success')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf192f9e16cd34f43530f7484bbd899b4)): ?>
<?php $attributes = $__attributesOriginalf192f9e16cd34f43530f7484bbd899b4; ?>
<?php unset($__attributesOriginalf192f9e16cd34f43530f7484bbd899b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf192f9e16cd34f43530f7484bbd899b4)): ?>
<?php $component = $__componentOriginalf192f9e16cd34f43530f7484bbd899b4; ?>
<?php unset($__componentOriginalf192f9e16cd34f43530f7484bbd899b4); ?>
<?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <?php if (isset($component)) { $__componentOriginal62ad3d909bae80241e25dfdeac681bdc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62ad3d909bae80241e25dfdeac681bdc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.error','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(session('error')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62ad3d909bae80241e25dfdeac681bdc)): ?>
<?php $attributes = $__attributesOriginal62ad3d909bae80241e25dfdeac681bdc; ?>
<?php unset($__attributesOriginal62ad3d909bae80241e25dfdeac681bdc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62ad3d909bae80241e25dfdeac681bdc)): ?>
<?php $component = $__componentOriginal62ad3d909bae80241e25dfdeac681bdc; ?>
<?php unset($__componentOriginal62ad3d909bae80241e25dfdeac681bdc); ?>
<?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
                    <?php if (isset($component)) { $__componentOriginal63113242d293ea3959317a7768671b4d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal63113242d293ea3959317a7768671b4d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.warning','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.warning'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(session('warning')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal63113242d293ea3959317a7768671b4d)): ?>
<?php $attributes = $__attributesOriginal63113242d293ea3959317a7768671b4d; ?>
<?php unset($__attributesOriginal63113242d293ea3959317a7768671b4d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal63113242d293ea3959317a7768671b4d)): ?>
<?php $component = $__componentOriginal63113242d293ea3959317a7768671b4d; ?>
<?php unset($__componentOriginal63113242d293ea3959317a7768671b4d); ?>
<?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>

            </main>

            <!-- Footer -->
            <footer class="bg-white border-t py-4 px-6 text-center text-sm text-gray-500">
                © <?php echo e(date('Y')); ?> Makamithi Sacco • Employee Savings & Credit Cooperative Society
            </footer>
        </div>

    </div>

    <!-- MOBILE SIDEBAR -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden">
        <div class="w-64 bg-white h-full shadow-xl p-6 overflow-y-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold text-green-700">Makamithi Sacco</h1>
                <button id="closeMenu" class="text-red-600 text-xl">✖</button>
            </div>

            <p class="text-green-700 text-sm mb-6">
                <?php echo e(ucfirst(auth()->user()->role)); ?> Panel
            </p>

            <nav class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userRole === 'member'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.savings.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.savings.index','current' => ''.e($current).'']); ?>💰 My Savings <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.apply','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.apply','current' => ''.e($current).'']); ?>📝 Apply Loan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.profile','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.profile','current' => ''.e($current).'']); ?>👤 My Profile <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.index','current' => ''.e($current).'']); ?>📜 My Loans <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'chairman'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.loan-approvals','current' => ''.e($current).'']); ?>✅ Loan Approvals <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.members','current' => ''.e($current).'']); ?>👥 Members <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'treasurer'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.dashboard','current' => ''.e($current).'']); ?>📊 Treasurer Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.payments','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.payments','current' => ''.e($current).'']); ?>💳 Payment Processing <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.loans','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.loans','current' => ''.e($current).'']); ?>📋 Loans Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.savings','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.savings','current' => ''.e($current).'']); ?>💰 Savings Summary <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.expenses','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.expenses','current' => ''.e($current).'']); ?>📊 Expenses Tracking <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.cheques','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.cheques','current' => ''.e($current).'']); ?>🏦 Cheque Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.reconciliation','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.reconciliation','current' => ''.e($current).'']); ?>✔️ Bank
                            Reconciliation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.financial-reports','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.financial-reports','current' => ''.e($current).'']); ?>📈 Financial
                            Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                        
                    <?php elseif($userRole === 'secretary'): ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.dashboard','current' => ''.e($current).'']); ?>📊 Dashboard <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.loan-approvals','current' => ''.e($current).'']); ?>✅ Loan Approvals <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.members','current' => ''.e($current).'']); ?>👥 Member Management <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.communications','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.communications','current' => ''.e($current).'']); ?>📧 Communications <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.documents','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.documents','current' => ''.e($current).'']); ?>📄 Documents <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 Reports <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- SETTINGS + LOGOUT -->
                    <div class="pt-6 mt-6 border-t border-green-200">
                        <a href="<?php echo e(route('settings')); ?>"
                            class="w-full block text-left px-4 py-2 text-green-700 hover:bg-green-100 rounded-lg">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </nav>

        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');

        if (menuToggle) menuToggle.onclick = () => mobileSidebar.classList.remove('hidden');
        if (closeMenu) closeMenu.onclick = () => mobileSidebar.classList.add('hidden');

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-auto-dismiss').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>

</body>

</html><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/components/dashboard-layout.blade.php ENDPATH**/ ?>