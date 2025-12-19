

<?php $__env->startSection('title', 'Chairman Dashboard'); ?>

<?php
    // Temporary fallback if recentActivities is not set
    $recentActivities = $recentActivities ?? collect();
?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Chairman Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Welcome back, <?php echo e(auth()->user()->name); ?>

                    </p>
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

        <!-- Pending Member Registrations -->
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
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Date</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingMembersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td class="px-3 py-2 border border-gray-300">
                                        <div class="text-gray-700"><?php echo e($member->created_at->format('d/m/Y')); ?></div>
                                    </td>
                                    <td class="px-3 py-2 border border-gray-300">
                                        <div class="flex gap-1">
                                            <a href="<?php echo e(route('chairman.member.details', $member->id)); ?>" 
                                                class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200">
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
                    <h3 class="text-base font-medium text-gray-900">No pending approvals</h3>
                    <p class="text-gray-500 text-xs mt-1">All members have been approved</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pending Loans -->
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
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Applied</th>
                                <th class="px-3 py-2 text-left text-gray-700 font-semibold border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $userSavings = $loan->user->savings?->available_savings ?? 0;
                                    $loanEligibility = $userSavings * 1.5;
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
                                        <?php echo e($loan->applied_date->format('d/m/y') ?? $loan->created_at->format('d/m/y')); ?>

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
                                    <?php echo e($activity->time->diffForHumans()); ?>

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
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentActivities->count() > 0): ?>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="<?php echo e(route('chairman.loan-approvals')); ?>" 
                           class="flex items-center justify-center gap-1 text-blue-600 hover:text-blue-800 text-xs font-medium">
                            <span>View All</span>
                            <span>→</span>
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

        <script>
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

            // Close modal when clicking outside
            window.onclick = function (event) {
                const reportModal = document.getElementById('reportModal');
                if (event.target == reportModal) {
                    closeReportModal();
                }
            }
        </script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/chairman/dashboard.blade.php ENDPATH**/ ?>