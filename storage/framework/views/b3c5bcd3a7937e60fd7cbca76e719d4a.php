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
        
        /* Base font sizes for mobile */
        html {
            font-size: 14px;
        }
        
        @media (min-width: 768px) {
            html {
                font-size: 16px;
            }
        }
        
        /* COLLAPSIBLE SIDEBAR STYLES - MODIFIED */
        .sidebar-collapsed {
            width: 4rem !important; /* Smaller on mobile */
        }

        .sidebar-collapsed .nav-text,
        .sidebar-collapsed h1,
        .sidebar-collapsed p {
            display: none;
        }

        .sidebar-collapsed nav a {
            justify-content: center;
            position: relative; /* For tooltip positioning */
        }

        /* Make icons slightly smaller when sidebar is collapsed on mobile */
        .sidebar-collapsed nav a {
            font-size: 1rem; /* Smaller on mobile */
            padding: 0.5rem 0;
        }

        @media (min-width: 768px) {
            .sidebar-collapsed nav a {
                font-size: 1.125rem; /* Slightly larger on desktop */
                padding: 0.75rem 0;
            }
            .sidebar-collapsed {
                width: 5rem !important;
            }
        }

        /* Tooltip styles */
        .nav-item {
            position: relative;
        }

        .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #1f2937;
            color: white;
            padding: 0.375rem 0.75rem; /* Smaller padding */
            border-radius: 0.25rem;
            font-size: 0.75rem; /* Smaller font */
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 50;
            margin-left: 0.5rem;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
            pointer-events: none;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border-width: 5px; /* Smaller arrow */
            border-style: solid;
            border-color: transparent #1f2937 transparent transparent;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 50;
            margin-left: -0.5rem;
            pointer-events: none;
        }

        .sidebar-collapsed .nav-item:hover::after,
        .sidebar-collapsed .nav-item:hover::before {
            opacity: 1;
            visibility: visible;
        }

        /* Specific styling for collapsed sidebar tooltips */
        .sidebar-collapsed .nav-item::after {
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .sidebar-collapsed .nav-item::before {
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border-color: transparent #1f2937 transparent transparent;
        }
        
        /* Mobile optimization */
        @media (max-width: 640px) {
            .text-sm-mobile {
                font-size: 0.75rem !important;
            }
            .text-xs-mobile {
                font-size: 0.65rem !important;
            }
            .p-2-mobile {
                padding: 0.5rem !important;
            }
            .text-lg-mobile {
                font-size: 1rem !important;
            }
            .text-xl-mobile {
                font-size: 1.125rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- SIDEBAR - MODIFIED -->
        <aside id="sidebar"
               class="hidden md:flex flex-col bg-white border-r shadow-sm
                      w-64 transition-all duration-300">  <!-- Added ID and transition classes -->

            <!-- Header - Smaller on mobile -->
            <div class="p-3 border-b bg-green-50">
                <h1 class="text-base font-bold text-green-700 flex items-center gap-2">
                    <span class="w-2 h-4 bg-orange-500 rounded"></span>
                    <span class="nav-text">Makamithi Sacco</span>
                </h1>

                <p class="text-xs text-green-700 mt-1 nav-text">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php echo e(ucfirst(auth()->user()->role)); ?> Panel
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>

            <!-- Navigation - Smaller font -->
            <nav class="flex-1 p-2 space-y-1 text-xs">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php
                        $userRole = auth()->user()->role;
                        $current = request()->route()->getName();
                    ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userRole === 'member'): ?>
                        <div class="nav-item" data-tooltip="Dashboard">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.dashboard','current' => ''.e($current).'']); ?>📊 <span class="nav-text">Dashboard</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="My Savings">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.savings.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.savings.index','current' => ''.e($current).'']); ?>💰 <span class="nav-text">My Savings</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Apply Loan">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.apply','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.apply','current' => ''.e($current).'']); ?>📝 <span class="nav-text">Apply Loan</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="My Profile">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.profile','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.profile','current' => ''.e($current).'']); ?>👤 <span class="nav-text">My Profile</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="My Loans">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.loans.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.loans.index','current' => ''.e($current).'']); ?>📜 <span class="nav-text">My Loans</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 <span class="nav-text">Documents</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'member.reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'member.reports.index','current' => ''.e($current).'']); ?>📈 <span class="nav-text">Reports</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 <span class="nav-text">Communications</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        


                        
                    <?php elseif($userRole === 'chairman'): ?>
                        <div class="nav-item" data-tooltip="Dashboard">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.dashboard','current' => ''.e($current).'']); ?>📊 <span class="nav-text">Dashboard</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Loan Approvals">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.loan-approvals','current' => ''.e($current).'']); ?>✅ <span class="nav-text">Loan Approvals</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 <span class="nav-text">Reports</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Members">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'chairman.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'chairman.members','current' => ''.e($current).'']); ?>👥 <span class="nav-text">Members</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 <span class="nav-text">Documents</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 <span class="nav-text">Communications</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>


                        
                    <?php elseif($userRole === 'treasurer'): ?>
                        <div class="nav-item" data-tooltip="Dashboard">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.dashboard','current' => ''.e($current).'']); ?>📊 <span class="nav-text">Treasurer Dashboard</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        
                        <!-- PAYROLL DEDUCTIONS LINK - ADDED -->
                        
                        
                        <div class="nav-item" data-tooltip="Payment Processing">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.payments','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.payments','current' => ''.e($current).'']); ?>💳 <span class="nav-text">Payment Processing</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Loans Management">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.loans','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.loans','current' => ''.e($current).'']); ?>📋 <span class="nav-text">Loans Management</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Savings Summary">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.savings','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.savings','current' => ''.e($current).'']); ?>💰 <span class="nav-text">Savings Summary</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Payroll Deductions">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.treasurer.savings.deductions','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.treasurer.savings.deductions','current' => ''.e($current).'']); ?>
                                💵 <span class="nav-text">Payroll Deductions</span>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Expenses Tracking">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.expenses','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.expenses','current' => ''.e($current).'']); ?>📊 <span class="nav-text">Expenses Tracking</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Cheque Management">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.cheques','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.cheques','current' => ''.e($current).'']); ?>🏦 <span class="nav-text">Cheque Management</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Financial Reports">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.financial-reports','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.financial-reports','current' => ''.e($current).'']); ?>📈 <span class="nav-text">Financial Reports</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'documents.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'documents.index','current' => ''.e($current).'']); ?>📄 <span class="nav-text">Documents</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 <span class="nav-text">Communications</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>


                        
                    <?php elseif($userRole === 'secretary'): ?>
                        <div class="nav-item" data-tooltip="Dashboard">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.dashboard','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.dashboard','current' => ''.e($current).'']); ?>📊 <span class="nav-text">Dashboard</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Loan Approvals">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.loan-approvals','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.loan-approvals','current' => ''.e($current).'']); ?>✅ <span class="nav-text">Loan Approvals</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Member Management">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.members','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.members','current' => ''.e($current).'']); ?>👥 <span class="nav-text">Member Management</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Communications">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.communications','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.communications','current' => ''.e($current).'']); ?>📧 <span class="nav-text">Communications</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Documents">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'secretary.documents','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'secretary.documents','current' => ''.e($current).'']); ?>📄 <span class="nav-text">Documents</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>
                        <div class="nav-item" data-tooltip="Reports">
                            <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'reports.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'reports.index','current' => ''.e($current).'']); ?>📈 <span class="nav-text">Reports</span> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $attributes = $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__attributesOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c)): ?>
<?php $component = $__componentOriginal5335e6a8fe017583baf62f034ee7c13c; ?>
<?php unset($__componentOriginal5335e6a8fe017583baf62f034ee7c13c); ?>
<?php endif; ?>
                        </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- SETTINGS + LOGOUT - Smaller -->
                    <div class="pt-3 mt-3 border-t border-green-200">
                        <div class="nav-item" data-tooltip="Settings">
                            <a href="<?php echo e(route('settings')); ?>"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-md
                                       text-green-700 hover:bg-green-100 text-xs">
                                ⚙️ <span class="nav-text">Settings</span>
                            </a>
                        </div>

                        <div class="nav-item" data-tooltip="Logout">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button
                                    class="w-full flex items-center gap-2 px-2 py-1.5
                                           text-red-600 hover:bg-red-100 rounded-md text-xs">
                                    🚪 <span class="nav-text">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header - Smaller on mobile -->
            <header class="bg-white border-b px-4 py-3 flex justify-between items-center shadow-sm">

                <!-- LEFT SIDE: Mobile toggle + Desktop toggle -->
                <div class="flex items-center gap-2">
                    <!-- Mobile Toggle Button -->
                    <button id="menuToggle" class="md:hidden text-gray-700 text-xl">☰</button>
                    
                    <!-- Desktop Toggle Button -->
                    <button id="desktopToggle" class="hidden md:inline-flex text-base text-gray-700">
                        ⮜
                    </button>
                </div>

                <!-- RIGHT SIDE: Notifications + User info - Smaller -->
                <div class="flex items-center space-x-3">

                    <!-- Notifications -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <div class="relative">
                            <a href="<?php echo e(route('communications.index')); ?>"
                                class="relative text-gray-600 hover:text-green-700 text-sm">
                                🔔
                                <?php
                                    $unreadCount = auth()->user()
                                        ->notifications()
                                        ->whereNull('read_at')
                                        ->count();
                                ?>


                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-2xs px-1 rounded-full">
                                        <?php echo e($unreadCount); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="hidden md:block text-right">
                        <p class="text-xs font-medium text-green-800"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-2xs text-green-600">
                            <?php echo e(ucfirst(auth()->user()->role)); ?> • <?php echo e(auth()->user()->employee_number ?? 'EMP001'); ?>

                        </p>
                    </div>

                    <div
                        class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                </div>

            </header>

            <!-- Page Body - Smaller padding on mobile -->
            <main class="flex-1 overflow-y-auto p-3 md:p-6">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <?php if (isset($component)) { $__componentOriginalf192f9e16cd34f43530f7484bbd899b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf192f9e16cd34f43530f7484bbd899b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.success','data' => ['class' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm']); ?><?php echo e(session('success')); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.error','data' => ['class' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm']); ?><?php echo e(session('error')); ?> <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert.warning','data' => ['class' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert.warning'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-sm']); ?><?php echo e(session('warning')); ?> <?php echo $__env->renderComponent(); ?>
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

            <!-- Footer - Smaller -->
            <footer class="bg-white border-t py-3 px-4 text-center text-xs text-gray-500">
                © <?php echo e(date('Y')); ?> Makamithi Sacco • Employee Savings & Credit Cooperative Society
            </footer>
        </div>

    </div>

    <!-- MOBILE SIDEBAR - Smaller fonts -->
    <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden">
        <div class="w-64 bg-white h-full shadow-xl p-4 overflow-y-auto">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg font-semibold text-green-700">Makamithi Sacco</h1>
                <button id="closeMenu" class="text-red-600 text-lg">✖</button>
            </div>

            <p class="text-green-700 text-xs mb-4">
                <?php echo e(ucfirst(auth()->user()->role)); ?> Panel
            </p>

            <nav class="space-y-1">
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
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 Communications <?php echo $__env->renderComponent(); ?>
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
                        <?php if (isset($component)) { $__componentOriginal5335e6a8fe017583baf62f034ee7c13c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5335e6a8fe017583baf62f034ee7c13c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 Communications <?php echo $__env->renderComponent(); ?>
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
                        <!-- ADDED FOR MOBILE -->
                        
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.treasurer.savings.deductions','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.treasurer.savings.deductions','current' => ''.e($current).'']); ?>💵 Payroll Deductions <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'treasurer.financial-reports','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'treasurer.financial-reports','current' => ''.e($current).'']); ?>📈 Financial Reports <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav.link','data' => ['route' => 'communications.index','current' => ''.e($current).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'communications.index','current' => ''.e($current).'']); ?>📧 Communications <?php echo $__env->renderComponent(); ?>
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
                    <div class="pt-4 mt-4 border-t border-green-200">
                        <a href="<?php echo e(route('settings')); ?>"
                            class="w-full block text-left px-3 py-1.5 text-green-700 hover:bg-green-100 rounded-lg text-sm">
                            ⚙️ Settings
                        </a>

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="w-full text-left px-3 py-1.5 text-red-600 hover:bg-red-100 rounded-lg text-sm">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </nav>

        </div>
    </div>

    <script>
        // Collapsing functionality
        const sidebar = document.getElementById('sidebar');
        const desktopToggle = document.getElementById('desktopToggle');
        const menuToggle = document.getElementById('menuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMenu = document.getElementById('closeMenu');

        // Restore sidebar state from localStorage
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('sidebar-collapsed');
            desktopToggle.textContent = '⮞';
        }

        // Desktop toggle for collapsing
        desktopToggle?.addEventListener('click', () => {
            const collapsed = sidebar.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed);
            desktopToggle.textContent = collapsed ? '⮞' : '⮜';
        });

        // Mobile menu toggle
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
        
        // Add text-2xs utility class if not exists
        const style = document.createElement('style');
        style.textContent = `
            .text-2xs { font-size: 0.625rem; line-height: 0.75rem; }
            @media (max-width: 640px) {
                .text-sm { font-size: 0.75rem; }
                .text-xs { font-size: 0.65rem; }
                h1, .text-lg { font-size: 1rem; }
                h2, .text-xl { font-size: 1.125rem; }
                h3, .text-2xl { font-size: 1.25rem; }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>

</html><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/components/dashboard-layout.blade.php ENDPATH**/ ?>