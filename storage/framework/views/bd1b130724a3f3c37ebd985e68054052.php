

<?php $__env->startSection('title', 'Chairman Dashboard'); ?>

<?php
    $recentActivities = $recentActivities ?? collect();
?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Chairman Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">Welcome back, <?php echo e(auth()->user()->name); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-lg font-semibold text-gray-800"><?php echo e(now()->format('d M Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Pending Approvals</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['pending_members'] ?? 0); ?></p>
                    </div>
                    <div class="text-2xl text-gray-300">⏳</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Approved This Month</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['approved_this_month'] ?? 0); ?></p>
                    </div>
                    <div class="text-2xl text-green-300">✔️</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Total Members</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['total_members'] ?? 0); ?></p>
                    </div>
                    <div class="text-2xl text-blue-300">👥</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Active Loans</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['active_loans'] ?? 0); ?></p>
                    </div>
                    <div class="text-2xl text-yellow-300">💰</div>
                </div>
            </div>
        </div>

        <!-- PENDING LOANS -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Pending Loan Approvals</h2>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($pendingLoans->count()); ?> pending</p>
                </div>
                <a href="<?php echo e(route('chairman.loan-approvals')); ?>"
                    class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingLoans->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">#</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Emp No</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Name</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Loan (KES)</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Eligible (KES)</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Savings (KES)</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Period</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Monthly (KES)</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Applied Date</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Applied Time</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sortedLoans = $pendingLoans->sortByDesc('created_at')->values();
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sortedLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $userSavings = $loan->user->savings?->available_savings ?? 0;
                                    $loanEligibility = $userSavings * 1.5;
                                    $appliedDate = $loan->applied_date ?? $loan->created_at;
                                ?>
                                <tr class="border-t border-gray-300 hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-900 font-medium border border-gray-300 text-center"><?php echo e($index + 1); ?></td>
                                    <td class="px-3 py-2 font-mono text-gray-900 border border-gray-300"><?php echo e($loan->user->employee_number ?? 'N/A'); ?></td>
                                    <td class="px-3 py-2 border border-gray-300">
                                        <p class="font-medium text-gray-900 truncate max-w-[100px]"><?php echo e($loan->user->name ?? 'N/A'); ?></p>
                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-right font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo e(number_format($loan->amount)); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-right text-gray-700 whitespace-nowrap">
                                        <?php echo e(number_format($loanEligibility)); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-right text-gray-700 whitespace-nowrap">
                                        <?php echo e(number_format($userSavings)); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-center">
                                        <span class="font-medium text-gray-900"><?php echo e($loan->period_months); ?></span>
                                        <span class="text-gray-500 text-xs ml-1">mo</span>
                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-right font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo e(number_format($loan->monthly_payment)); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-center text-gray-700">
                                        <?php echo e($appliedDate->format('d/m/Y')); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-center text-gray-700">
                                        <?php echo e($appliedDate->format('h:i A')); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300">
                                        <div class="flex gap-1">
                                            <a href="<?php echo e(route('chairman.loans.approve-view', $loan->id)); ?>" 
                                                class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200 whitespace-nowrap">
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-6 border border-gray-300 rounded-lg">
                    <div class="text-3xl mb-2">✅</div>
                    <h3 class="text-base font-medium text-gray-900">No pending loan approvals</h3>
                    <p class="text-gray-500 text-xs mt-1">All loan applications have been reviewed</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- PENDING MEMBER REGISTRATIONS -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Pending Member Approvals</h2>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($pendingMembersList->count()); ?> pending</p>
                </div>
                <a href="<?php echo e(route('chairman.members')); ?>"
                    class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingMembersList->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">#</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Emp No</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Name</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Dept</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Submitted By</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Applied Date</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Applied Time</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sortedMembers = $pendingMembersList->sortByDesc('created_at')->values();
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sortedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-300 hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-900 font-medium border border-gray-300 text-center"><?php echo e($index + 1); ?></td>
                                    <td class="px-3 py-2 font-mono text-gray-900 border border-gray-300"><?php echo e($member->employee_number ?? 'N/A'); ?></td>
                                    <td class="px-3 py-2 border border-gray-300">
                                        <p class="font-medium text-gray-900"><?php echo e($member->name); ?></p>
                                    </td>
                                    <td class="px-3 py-2 text-gray-700 border border-gray-300"><?php echo e($member->department ?? 'N/A'); ?></td>
                                    <td class="px-3 py-2 text-gray-700 border border-gray-300">
                                        <?php echo e($member->memberApproval?->submittedBy?->name ?? 'System'); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-center text-gray-700">
                                        <?php echo e($member->created_at->format('d/m/Y')); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300 text-center text-gray-700">
                                        <?php echo e($member->created_at->format('h:i A')); ?>

                                    </td>
                                    <td class="px-3 py-2 border border-gray-300">
                                        <div class="flex gap-1">
                                            <!-- Changed from <a> link to button with onclick -->
                                            <button onclick="viewMemberDetails(<?php echo e($member->id); ?>)"
                                                class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200">
                                                View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-6 border border-gray-300 rounded-lg">
                    <div class="text-3xl mb-2">✅</div>
                    <h3 class="text-base font-medium text-gray-900">No pending approvals</h3>
                    <p class="text-gray-500 text-xs mt-1">All members have been approved</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Activity + Reports -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                        <p class="text-gray-500 text-xs mt-1">Last 7 days</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium whitespace-nowrap">
                        Latest
                    </span>
                </div>

                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e($activity->link ?? '#'); ?>" 
                           class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="p-1.5 rounded-full bg-gray-100 mr-3 text-base flex-shrink-0">
                                <?php echo e($activity->icon); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate">
                                    <?php echo e($activity->title); ?>

                                </p>
                                <p class="text-gray-600 text-xs truncate">
                                    <?php echo e($activity->member); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity->amount): ?>
                                        — KES <?php echo e(number_format($activity->amount)); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                                <p class="text-gray-400 text-xs mt-0.5">
                                    <?php echo e($activity->time->format('d/m/Y h:i A')); ?>

                                </p>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity->type === 'loan_approved' || $activity->type === 'member_approved'): ?>
                                <span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium ml-2 flex-shrink-0">
                                    ✓
                                </span>
                            <?php elseif($activity->type === 'loan_applied' || $activity->type === 'member_applied'): ?>
                                <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs font-medium ml-2 flex-shrink-0">
                                    ⏳
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-6 border border-gray-300 rounded-lg">
                            <div class="text-3xl mb-2">📊</div>
                            <h3 class="text-base font-medium text-gray-900">No Recent Activity</h3>
                            <p class="text-gray-500 text-xs mt-1">Activities will appear here</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Quick Reports -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Generate Reports</h2>
                        <p class="text-gray-500 text-xs mt-1">Quick report generation</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <button onclick="openReportModal('financial')" class="w-full flex items-center justify-start gap-3 bg-blue-50 text-blue-700 py-2.5 px-3 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                        <span class="text-base">📊</span>
                        <span class="text-sm font-medium">Financial Report</span>
                    </button>
                    <button onclick="openReportModal('loan_performance')" class="w-full flex items-center justify-start gap-3 bg-green-50 text-green-700 py-2.5 px-3 rounded-lg hover:bg-green-100 transition border border-green-200">
                        <span class="text-base">💰</span>
                        <span class="text-sm font-medium">Loan Performance</span>
                    </button>
                    <button onclick="openReportModal('members')" class="w-full flex items-center justify-start gap-3 bg-purple-50 text-purple-700 py-2.5 px-3 rounded-lg hover:bg-purple-100 transition border border-purple-200">
                        <span class="text-base">👥</span>
                        <span class="text-sm font-medium">Member Statistics</span>
                    </button>
                    <button onclick="openReportModal('savings')" class="w-full flex items-center justify-start gap-3 bg-orange-50 text-orange-700 py-2.5 px-3 rounded-lg hover:bg-orange-100 transition border border-orange-200">
                        <span class="text-base">📈</span>
                        <span class="text-sm font-medium">Savings Growth</span>
                    </button>
                    <a href="<?php echo e(route('reports.index')); ?>" class="w-full flex items-center justify-start gap-3 bg-gray-50 text-gray-700 py-2.5 px-3 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                        <span class="text-base">📋</span>
                        <span class="text-sm font-medium">View All Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Member Details Modal -->
        <div id="memberDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900">Member Details</h3>
                        <button onclick="closeMemberDetails()" class="text-gray-500 hover:text-gray-700">✕</button>
                    </div>
                    <p class="text-gray-500 text-sm mt-1" id="modalMemberNumber"></p>
                </div>

                <div class="p-6">
                    <div id="memberDetailsContent">
                        <!-- Content will be loaded here by JavaScript -->
                        <div class="text-center py-10">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto"></div>
                            <p class="text-gray-500 mt-4">Loading member details...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approval Confirmation Modal -->
        <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-md">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-900" id="approvalTitle">Approve Member</h3>
                    <p class="text-gray-500 text-sm mt-1" id="approvalMessage"></p>
                </div>

                <div class="p-6 space-y-4">
                    <div id="rejectionReason" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                        <textarea id="rejectionComments" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Provide reason for rejection..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button onclick="closeApprovalModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">Cancel</button>
                        <button onclick="confirmApproval()" id="confirmApproveBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition hidden">✅ Approve</button>
                        <button onclick="confirmRejection()" id="confirmRejectBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition hidden">❌ Reject</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Generation Modal -->
        <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-xl w-full max-w-sm">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900" id="reportTitle">Generate Report</h3>
                </div>

                <form action="<?php echo e(route('reports.generate')); ?>" method="POST" class="p-4 space-y-3">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="report_type" id="reportType">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                            value="<?php echo e(now()->subMonths(3)->toDateString()); ?>">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                            value="<?php echo e(now()->toDateString()); ?>">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Format</label>
                        <select name="format" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>

                    <div class="flex gap-2 pt-3">
                        <button type="button" onclick="closeReportModal()"
                            class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg font-medium hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg font-medium transition">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // State variables
        let currentMemberId = null;
        let approvalAction = '';

        // View member details
        async function viewMemberDetails(id) {
            try {
                currentMemberId = id;
                
                // Show loading in modal
                document.getElementById('memberDetailsContent').innerHTML = `
                    <div class="text-center py-10">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto"></div>
                        <p class="text-gray-500 mt-4">Loading member details...</p>
                    </div>
                `;
                
                // Show modal
                document.getElementById('memberDetailsModal').classList.remove('hidden');
                
                // Fetch member details
                const response = await fetch(`/chairman/member/${id}/details`);
                const data = await response.json();

                if (data.success) {
                    const member = data.member;
                    document.getElementById('modalMemberNumber').textContent = `Employee: ${member.employee_number}`;

                    const detailsHtml = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">Full Name</p>
                                        <p class="font-medium text-gray-900">${member.name}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email Address</p>
                                        <p class="font-medium text-gray-900">${member.email}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone Number</p>
                                        <p class="font-medium text-gray-900">${member.phone}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Date Joined</p>
                                        <p class="font-medium text-gray-900">${member.date_joined}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">Department</p>
                                        <p class="font-medium text-gray-900">${member.department}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Position</p>
                                        <p class="font-medium text-gray-900">${member.position}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Employee Number</p>
                                        <p class="font-medium text-gray-900">${member.employee_number}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Member Status</p>
                                        <p class="font-medium ${member.status === 'active' ? 'text-green-600' : member.status === 'pending' ? 'text-yellow-600' : 'text-red-600'}">${member.status.charAt(0).toUpperCase() + member.status.slice(1)}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="md:col-span-2">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Financial Summary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Total Savings</p>
                                        <p class="text-2xl font-semibold text-gray-900">KES ${member.savings.toLocaleString()}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Loan Eligibility</p>
                                        <p class="text-2xl font-semibold text-gray-900">KES ${member.loan_eligibility.toLocaleString()}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Loan Status</p>
                                        <p class="text-xl font-semibold ${member.loan_status === 'active' ? 'text-blue-600' : member.loan_status === 'default' ? 'text-red-600' : 'text-gray-600'}">${member.loan_status_text}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            ${member.status === 'pending' ? `
                            <div class="md:col-span-2 pt-6 border-t">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Approval Actions</h4>
                                <div class="flex space-x-4">
                                    <button onclick="approveMember(${member.id})" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                                        <span class="mr-2">✅</span> Approve Member
                                    </button>
                                    <button onclick="rejectMember(${member.id})" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                                        <span class="mr-2">❌</span> Reject Member
                                    </button>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    `;

                    document.getElementById('memberDetailsContent').innerHTML = detailsHtml;
                } else {
                    document.getElementById('memberDetailsContent').innerHTML = `
                        <div class="text-center py-10">
                            <div class="text-3xl mb-4">❌</div>
                            <h3 class="text-lg font-medium text-gray-900">Error Loading Details</h3>
                            <p class="text-gray-500 mt-1">Failed to load member details. Please try again.</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading member details:', error);
                document.getElementById('memberDetailsContent').innerHTML = `
                    <div class="text-center py-10">
                        <div class="text-3xl mb-4">❌</div>
                        <h3 class="text-lg font-medium text-gray-900">Connection Error</h3>
                        <p class="text-gray-500 mt-1">Unable to connect to server. Please check your internet connection.</p>
                    </div>
                `;
            }
        }

        function closeMemberDetails() {
            document.getElementById('memberDetailsModal').classList.add('hidden');
            currentMemberId = null;
        }

        // Approve member
        function approveMember(id) {
            const memberName = document.querySelector('#memberDetailsContent .font-medium.text-gray-900')?.textContent || 'this member';
            currentMemberId = id;
            approvalAction = 'approve';

            document.getElementById('approvalTitle').textContent = 'Approve Member';
            document.getElementById('approvalMessage').textContent = `Approve ${memberName} as a SACCO member?`;
            document.getElementById('rejectionReason').classList.add('hidden');
            document.getElementById('confirmApproveBtn').classList.remove('hidden');
            document.getElementById('confirmRejectBtn').classList.add('hidden');
            document.getElementById('rejectionComments').value = '';

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        // Reject member
        function rejectMember(id) {
            const memberName = document.querySelector('#memberDetailsContent .font-medium.text-gray-900')?.textContent || 'this member';
            currentMemberId = id;
            approvalAction = 'reject';

            document.getElementById('approvalTitle').textContent = 'Reject Member';
            document.getElementById('approvalMessage').textContent = `Reject ${memberName}'s membership application?`;
            document.getElementById('rejectionReason').classList.remove('hidden');
            document.getElementById('confirmApproveBtn').classList.add('hidden');
            document.getElementById('confirmRejectBtn').classList.remove('hidden');
            document.getElementById('rejectionComments').value = '';

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        function closeApprovalModal() {
            document.getElementById('approvalModal').classList.add('hidden');
            currentMemberId = null;
            approvalAction = '';
            document.getElementById('rejectionComments').value = '';
        }

        async function confirmApproval() {
            if (!currentMemberId) return;

            try {
                const formData = new FormData();
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('action', 'approve');
                formData.append('notes', '');
                formData.append('rejection_reason', ''); // Empty for approval

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert('Member approved successfully!');
                    window.location.reload();
                } else {
                    const error = await response.json();
                    alert(`Failed to approve member: ${error.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error approving member. Please try again.');
            }
        }

        async function confirmRejection() {
            if (!currentMemberId) return;

            const reason = document.getElementById('rejectionComments').value;
            if (!reason.trim()) {
                alert('Please provide a reason for rejection');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('action', 'reject');
                formData.append('rejection_reason', reason);
                formData.append('notes', '');

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    alert('Member rejected successfully!');
                    window.location.reload();
                } else {
                    const error = await response.json();
                    alert(`Failed to reject member: ${error.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error rejecting member. Please try again.');
            }
        }

        // Report modal functions
        function openReportModal(reportType) {
            const titles = {
                'financial': 'Generate Financial Report',
                'loan_performance': 'Loan Performance Report',
                'members': 'Member Statistics Report',
                'savings': 'Savings Growth Report'
            };
            document.getElementById('reportType').value = reportType;
            document.getElementById('reportTitle').textContent = titles[reportType];
            document.getElementById('reportModal').classList.remove('hidden');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }

        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function () {
            // Close modals when clicking outside
            window.onclick = function (event) {
                const memberModal = document.getElementById('memberDetailsModal');
                const approvalModal = document.getElementById('approvalModal');
                const reportModal = document.getElementById('reportModal');

                if (event.target == memberModal) closeMemberDetails();
                if (event.target == approvalModal) closeApprovalModal();
                if (event.target == reportModal) closeReportModal();
            }

            // Close with Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeMemberDetails();
                    closeApprovalModal();
                    closeReportModal();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/chairman/dashboard.blade.php ENDPATH**/ ?>