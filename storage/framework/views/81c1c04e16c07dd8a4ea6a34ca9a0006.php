

<?php $__env->startSection('title', 'Secretary Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Secretary Dashboard</h1>
                    <p class="text-gray-500 text-sm md:text-base mt-1">
                        Welcome back, <?php echo e(auth()->user()->name); ?> — manage members, communications, and SACCO operations.
                    </p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-lg md:text-xl font-semibold text-gray-800"><?php echo e(now()->format('d M Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Stats Cards - Adjusted for smaller screens -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Members -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Total Members</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['total_members']); ?></p>
                    </div>
                    <div class="text-2xl">👥</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-green-600 text-xs font-medium">
                        +<?php echo e($stats['new_this_month']); ?> this month
                    </span>
                </div>
            </div>

            <!-- Total Savings -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">
                            KES <?php echo e(number_format($stats['total_savings'], 1)); ?>

                        </p>
                    </div>
                    <div class="text-2xl">💰</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-blue-600 text-xs font-medium">
                        +<?php echo e(number_format($stats['savings_growth_percentage'], 1)); ?>% growth
                    </span>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">
                            KES <?php echo e(number_format($stats['total_active_loans'], 1)); ?>

                        </p>
                    </div>
                    <div class="text-2xl">📝</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-orange-600 text-xs font-medium">
                        <?php echo e($stats['active_loans_count']); ?> active loans
                    </span>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Pending Approvals</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">
                            <?php echo e($stats['pending_approvals']); ?>

                        </p>
                    </div>
                    <div class="text-2xl">⏳</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-purple-600 text-xs font-medium">
                        <?php echo e($stats['pending_loans']); ?> loans, <?php echo e($stats['pending_members']); ?> members
                    </span>
                </div>
            </div>
        </div>

        <!-- Secretary Operations - Adjusted grid -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">Secretary Operations</h2>
                    <p class="text-gray-500 text-sm">Core administrative functions</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 bg-blue-100 text-blue-800 rounded-full">4 Functions</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                <!-- Add New Member -->
                <a href="<?php echo e(route('secretary.members')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-700 text-sm">👤</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-700">Member Management</h3>
                                <p class="text-gray-500 text-xs">Register & manage members</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium">
                                <?php echo e($stats['total_members']); ?> total members
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Loan Assistance -->
                <a href="<?php echo e(route('secretary.loan-assist')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-700 text-sm">🤝</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-blue-700">Loan Assistance</h3>
                                <p class="text-gray-500 text-xs">Help members apply</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-blue-600 text-xs font-medium">
                                <?php echo e($stats['active_loans_count']); ?> active loans
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Loan Approvals -->
                <a href="<?php echo e(route('secretary.loan-approvals')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-700 text-sm">✅</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-blue-700">Loan Approvals</h3>
                                <p class="text-gray-500 text-xs">Review applications</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-blue-600 text-xs font-medium">
                                <?php echo e($stats['pending_loans']); ?> pending
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Communications -->
                <a href="<?php echo e(route('communications.index')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-700 text-sm">📨</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-700">Communications</h3>
                                <p class="text-gray-500 text-xs">Send notifications</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium">
                                <?php echo e($stats['total_members']); ?> recipients
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Pending Member Approvals - Excel-like table -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Pending Member Approvals</h2>
                <a href="<?php echo e(route('secretary.members')); ?>?status=pending"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All (<?php echo e($stats['pending_members']); ?>)
                </a>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pendingMembers) > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    #
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Member Name
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Employee No.
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Department
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Days Pending
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $daysPending = now()->diffInDays($member->created_at);
                                    $statusColor = $daysPending == 0 ? 'text-green-600' : ($daysPending <= 2 ? 'text-orange-600' : 'text-red-600');
                                ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <span class="text-gray-700 font-medium"><?php echo e(substr($member->name, 0, 1)); ?></span>
                                            </div>
                                            <span class="text-sm text-gray-900"><?php echo e($member->name); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <?php echo e($member->employee_number); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                        <?php echo e($member->department); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium border border-gray-300">
                                        <span class="<?php echo e($statusColor); ?>">
                                            <?php echo e($daysPending == 0 ? 'Today' : $daysPending . ' days'); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <a href="<?php echo e(route('secretary.members.show', $member)); ?>" 
                                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-8 border border-gray-300 rounded-lg">
                    <div class="text-3xl mb-3">📋</div>
                    <h4 class="text-base font-medium text-gray-900 mb-1">No Pending Approvals</h4>
                    <p class="text-gray-500 text-sm">All members are approved</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Assisted Loans -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Assisted Loans</h3>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        Total: <?php echo e(count($recentLoans)); ?>

                    </span>
                </div>

                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusColor = match($loan->status) {
                                'approved' => 'text-green-600',
                                'disbursed' => 'text-blue-600',
                                'active' => 'text-blue-600',
                                'pending' => 'text-orange-600',
                                'rejected' => 'text-red-600',
                                default => 'text-gray-600'
                            };
                            
                            $statusText = match($loan->status) {
                                'approved' => 'Approved',
                                'disbursed' => 'Disbursed',
                                'active' => 'Active',
                                'pending' => 'Pending',
                                'rejected' => 'Rejected',
                                default => $loan->status
                            };
                            
                            $daysAgo = $loan->applied_date ? now()->diffInDays($loan->applied_date) : 0;
                            $dateText = $daysAgo == 0 ? 'Today' : ($daysAgo == 1 ? 'Yesterday' : $daysAgo . ' days ago');
                        ?>
                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <span class="text-blue-600 text-sm">📝</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">
                                        <?php echo e($loan->user->name ?? 'Unknown Member'); ?>

                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        KES <?php echo e(number_format($loan->amount)); ?> • <?php echo e($loan->loan_number); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold <?php echo e($statusColor); ?>">
                                    <?php echo e($statusText); ?>

                                </span>
                                <p class="text-gray-500 text-xs"><?php echo e($dateText); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8">
                            <div class="text-3xl mb-3">📝</div>
                            <h4 class="text-base font-medium text-gray-900 mb-1">No Assisted Loans</h4>
                            <p class="text-gray-500 text-sm">No loan assistance records found</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Member Statistics -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Member Status Overview</h3>

                <div class="space-y-3">
                    <?php
                        $memberStats = [
                            [
                                'label' => 'New Applications This Month', 
                                'value' => $stats['new_this_month'], 
                                'icon' => '📥', 
                                'color' => 'bg-blue-50',
                                'route' => 'secretary.members'
                            ],
                            [
                                'label' => 'Members Requiring Follow-up', 
                                'value' => $stats['pending_members'], 
                                'icon' => '📞', 
                                'color' => 'bg-orange-50',
                                'route' => 'secretary.members'
                            ],
                            [
                                'label' => 'Overdue Loan Payments', 
                                'value' => $stats['overdue_loans'] ?? 0, 
                                'icon' => '⏰', 
                                'color' => 'bg-red-50',
                                'route' => 'secretary.loan-history'
                            ],
                            [
                                'label' => 'Pending Documentation', 
                                'value' => $stats['pending_documents'] ?? 0, 
                                'icon' => '📄', 
                                'color' => 'bg-yellow-50',
                                'route' => 'secretary.documents'
                            ],
                        ];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $memberStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg <?php echo e($stat['color']); ?> flex items-center justify-center">
                                    <span class="text-sm"><?php echo e($stat['icon']); ?></span>
                                </div>
                                <span class="text-sm text-gray-600"><?php echo e($stat['label']); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-900 font-semibold text-sm">
                                    <?php echo e($stat['value']); ?>

                                </span>
                                <a href="<?php echo e(route($stat['route'])); ?>" class="text-xs text-gray-500 hover:text-gray-700">
                                    View →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Upcoming Meetings -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($upcomingMeetings) > 0): ?>
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">Upcoming Meetings</h2>
                    <p class="text-gray-500 text-sm">SACCO meetings and events</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 bg-purple-100 text-purple-800 rounded-full">
                        <?php echo e(count($upcomingMeetings)); ?> upcoming
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcomingMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $meetingDate = \Carbon\Carbon::parse($meeting['date']);
                        $isToday = $meetingDate->isToday();
                        $isTomorrow = $meetingDate->isTomorrow();
                        $daysDiff = now()->diffInDays($meetingDate, false);
                    ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900"><?php echo e($meeting['title']); ?></h3>
                                <p class="text-gray-500 text-sm mt-1"><?php echo e($meeting['description'] ?? 'SACCO Meeting'); ?></p>
                            </div>
                            <div class="text-2xl">📅</div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700"><?php echo e($meetingDate->format('d M Y')); ?></span>
                                <span class="text-gray-500">•</span>
                                <span class="text-gray-700"><?php echo e($meeting['time'] ?? '2:00 PM'); ?></span>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isToday): ?> bg-green-100 text-green-800
                                <?php elseif($isTomorrow): ?> bg-blue-100 text-blue-800
                                <?php elseif($daysDiff < 7): ?> bg-orange-100 text-orange-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isToday): ?> Today
                                <?php elseif($isTomorrow): ?> Tomorrow
                                <?php elseif($daysDiff < 7): ?> In <?php echo e($daysDiff); ?> days
                                <?php else: ?> <?php echo e($meetingDate->format('M d')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($meeting['venue'])): ?>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span>📍</span>
                                <span><?php echo e($meeting['venue']); ?></span>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Quick Actions -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="<?php echo e(route('secretary.members.create')); ?>"
                    class="flex items-center justify-center gap-2 bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition text-sm">
                    <span>👤</span>
                    <span>Add Member</span>
                </a>

                <a href="<?php echo e(route('secretary.loan-assist')); ?>"
                    class="flex items-center justify-center gap-2 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                    <span>🤝</span>
                    <span>Loan Assistance</span>
                </a>

                <a href="<?php echo e(route('secretary.loan-approvals')); ?>"
                    class="flex items-center justify-center gap-2 bg-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-purple-700 transition text-sm">
                    <span>✅</span>
                    <span>Review Loans</span>
                </a>

                <a href="<?php echo e(route('communications.create')); ?>"
                    class="flex items-center justify-center gap-2 bg-orange-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-700 transition text-sm">
                    <span>📨</span>
                    <span>Send Notifications</span>
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/dashboard.blade.php ENDPATH**/ ?>