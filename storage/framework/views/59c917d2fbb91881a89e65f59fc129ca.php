<?php $__env->startSection('title', 'Member Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">👥</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Member Management</h1>
                        <p class="text-gray-500 text-sm md:text-base">Add new members and manage existing member information</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Total Members</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_members'] ?? 0); ?></p>
                    <p class="text-gray-500 text-xs mt-1">All registered members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Members</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_members'] ?? 0); ?></p>
                    <p class="text-gray-500 text-sm mt-1">All registered</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">👥</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Members</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['active_members'] ?? 0); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Approved and active</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Approval</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['pending_members'] ?? 0); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting approval</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">New This Month</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['new_this_month'] ?? 0); ?></p>
                    <p class="text-gray-500 text-sm mt-1"><?php echo e(now()->format('F')); ?> registrations</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">📈</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('all')" id="allTab"
                    class="px-6 py-4 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap">
                    👥 All Members (<?php echo e($stats['total_members'] ?? 0); ?>)
                </button>
                <button onclick="switchTab('active')" id="activeTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Active (<?php echo e($stats['active_members'] ?? 0); ?>)
                </button>
                <button onclick="switchTab('pending')" id="pendingTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ⏳ Pending (<?php echo e($stats['pending_members'] ?? 0); ?>)
                </button>
                <button onclick="switchTab('rejected')" id="rejectedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ❌ Rejected (<?php echo e($stats['rejected_members'] ?? 0); ?>)
                </button>
            </nav>
        </div>

        <!-- All Members -->
        <div id="allContent" class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">All Members List</h3>
                    <p class="text-gray-500 text-sm">Complete member directory</p>
                </div>
                <div class="flex gap-2">
                    <input type="text" placeholder="Search members..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="searchInput">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="departmentFilter">
                        <option value="">All Departments</option>
                        <?php
                            $departments = \App\Models\User::where('role', 'member')
                                ->select('department')
                                ->distinct()
                                ->pluck('department');
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept); ?>"><?php echo e($dept); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <a href="<?php echo e(route('secretary.members.create')); ?>"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition flex items-center gap-2">
                        <span>+</span> Add Member
                    </a>
                </div>
            </div>

            <!-- Members Table -->
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member Details</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Department</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Position</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                    <?php echo e(($members->currentPage() - 1) * $members->perPage() + $index + 1); ?>

                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-sm font-medium">
                                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($member->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($member->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                    <?php echo e($member->employee_number); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->department); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->position); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->phone); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->sacco_status === 'active'): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200 font-medium">✅ Active</span>
                                    <?php elseif($member->sacco_status === 'pending'): ?>
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full border border-orange-200 font-medium">⏳ Pending</span>
                                    <?php elseif($member->sacco_status === 'rejected'): ?>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full border border-red-200 font-medium">❌ Rejected</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full border border-gray-200 font-medium">Unknown</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('secretary.members.show', $member->id)); ?>"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                            View
                                        </a>
                                        <a href="<?php echo e(route('secretary.members.edit', $member->id)); ?>"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    No members found. <a href="<?php echo e(route('secretary.members.create')); ?>" class="text-blue-600 hover:text-blue-800">Add your first member!</a>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($members->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($members->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Active Members -->
        <div id="activeContent" class="p-6 hidden">
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member Details</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Department</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Savings Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                            $activeMembers = $members->where('sacco_status', 'active');
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $activeMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                    <?php echo e($index + 1); ?>

                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-sm font-medium">
                                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($member->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($member->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                    <?php echo e($member->employee_number); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->department); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->savings): ?>
                                        KES <?php echo e(number_format($member->savings->available_savings, 2)); ?>

                                    <?php else: ?>
                                        <span class="text-gray-400">No savings</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200 font-medium">✅ Active</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    No active members found.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Members -->
        <div id="pendingContent" class="p-6 hidden">
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member Details</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Applied Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                            $pendingMembers = $members->where('sacco_status', 'pending');
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                    <?php echo e($index + 1); ?>

                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-sm font-medium">
                                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($member->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($member->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                    <?php echo e($member->employee_number); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->created_at->format('d M Y')); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('secretary.members.show', $member->id)); ?>"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No pending members.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rejected Members -->
        <div id="rejectedContent" class="p-6 hidden">
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member Details</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Rejection Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                            $rejectedMembers = $members->where('sacco_status', 'rejected');
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $rejectedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                    <?php echo e($index + 1); ?>

                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-sm font-medium">
                                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($member->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($member->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                    <?php echo e($member->employee_number); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                    <?php echo e($member->updated_at->format('d M Y')); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                    <div class="flex gap-2">
                                        <form method="POST" action="<?php echo e(route('secretary.members.approve', $member->id)); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Approve
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('secretary.members.show', $member->id)); ?>"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No rejected members.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Reports</h3>
            <div class="space-y-3">
                <a href="<?php echo e(route('secretary.reports.members.new')); ?>"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📊 New Members Report</span>
                    <span class="text-gray-400">→</span>
                </a>
                <a href="<?php echo e(route('secretary.reports.savings')); ?>"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>💰 Savings Summary Report</span>
                    <span class="text-gray-400">→</span>
                </a>
                <a href="<?php echo e(route('secretary.reports.departments')); ?>"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>🏢 Department Analysis</span>
                    <span class="text-gray-400">→</span>
                </a>
                <button onclick="exportMemberData()"
                    class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center border border-green-200">
                    <span>💾 Export Member Data (Excel)</span>
                    <span class="text-green-600">→</span>
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?php echo e(route('secretary.members.create')); ?>"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>👤</span> Add New Member
                </a>
                <a href="<?php echo e(route('secretary.loan-assist')); ?>"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📝</span> Assist with Loan Application
                </a>
                <button onclick="sendBulkMessages()"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📧</span> Send Bulk Messages
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Reject Member</h3>
        </div>
        
        <form id="rejectionForm" method="POST" action="">
            <?php echo csrf_field(); ?>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection *</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                        placeholder="Enter reason for rejection..." required></textarea>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
                <button type="button" onclick="closeRejectionModal()"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        document.getElementById('allContent').classList.add('hidden');
        document.getElementById('activeContent').classList.add('hidden');
        document.getElementById('pendingContent').classList.add('hidden');
        document.getElementById('rejectedContent').classList.add('hidden');

        // Remove active from all tabs
        document.getElementById('allTab').classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById('allTab').classList.add('text-gray-500');
        document.getElementById('activeTab').classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById('activeTab').classList.add('text-gray-500');
        document.getElementById('pendingTab').classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById('pendingTab').classList.add('text-gray-500');
        document.getElementById('rejectedTab').classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById('rejectedTab').classList.add('text-gray-500');

        // Show selected content
        document.getElementById(tabName + 'Content').classList.remove('hidden');

        // Activate selected tab
        document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-blue-600', 'text-blue-700');
        document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
    }

    // Rejection modal functions
    let currentMemberId = null;

    function rejectMember(memberId) {
        currentMemberId = memberId;
        const form = document.getElementById('rejectionForm');
        form.action = `/secretary/members/${memberId}/reject`;
        document.getElementById('rejectionModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeRejectionModal() {
        document.getElementById('rejectionModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('rejectionForm').reset();
        currentMemberId = null;
    }

    // Search functionality
    function filterMembers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const departmentFilter = document.getElementById('departmentFilter').value;
        const currentTab = document.querySelector('[class*="border-blue-600"]').id.replace('Tab', '');
        
        let rows = document.querySelectorAll(`#${currentTab}Content tbody tr`);
        
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const employeeNumber = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const department = row.querySelector('td:nth-child(4)').textContent;
            const email = row.querySelector('td:nth-child(2) p.text-gray-500').textContent.toLowerCase();
            
            const matchesSearch = name.includes(searchTerm) || 
                                employeeNumber.includes(searchTerm) || 
                                email.includes(searchTerm);
            const matchesDepartment = departmentFilter ? department === departmentFilter : true;
            
            row.style.display = (matchesSearch && matchesDepartment) ? '' : 'none';
        });
    }

    // Action functions
    function exportMemberData() {
        if (confirm('Export all member data to Excel?')) {
            // AJAX call to generate export
            fetch('/secretary/members/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `members-export-${new Date().toISOString().split('T')[0]}.xlsx`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Export failed:', error));
        }
    }

    function sendBulkMessages() {
        alert('Bulk messaging feature would open here.');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('all');
        
        // Add event listeners for search and filter
        document.getElementById('searchInput').addEventListener('input', filterMembers);
        document.getElementById('departmentFilter').addEventListener('change', filterMembers);

        // Close modal when clicking outside
        document.getElementById('rejectionModal').addEventListener('click', function(e) {
            if (e.target.id === 'rejectionModal') {
                closeRejectionModal();
            }
        });
    });

    // Success messages
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        alert('<?php echo e(session('success')); ?>');
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        alert('Error: <?php echo e(session('error')); ?>');
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/members.blade.php ENDPATH**/ ?>