

<?php $__env->startSection('title', 'Loan Approvals'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header Banner -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Loan Approval System</h1>
                    <p class="text-gray-500 mt-2 leading-relaxed">
                        Review, verify, and approve member loan applications
                    </p>
                </div>

                <div class="text-left md:text-right mt-6 md:mt-0">
                    <p class="text-gray-500">Pending Approvals</p>
                    <p class="text-4xl font-semibold text-gray-900 mt-1"><?php echo e($stats['pending_loans']); ?></p>
                    <p class="text-gray-400 text-sm mt-1">Awaiting your review</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Pending Review</h3>
                <p class="text-3xl font-semibold text-gray-900 mt-2"><?php echo e($stats['pending_loans']); ?></p>
                <p class="text-gray-500 text-sm mt-1">Needs your approval</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Approved Today</h3>
                <p class="text-3xl font-semibold text-gray-900 mt-2"><?php echo e($stats['approved_today']); ?></p>
                <p class="text-gray-500 text-sm mt-1">Approved in last 24 hours</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Total Approved</h3>
                <p class="text-3xl font-semibold text-gray-900 mt-2"><?php echo e($stats['total_approved']); ?></p>
                <p class="text-gray-500 text-sm mt-1">All time approvals</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Disbursed</h3>
                <p class="text-3xl font-semibold text-gray-900 mt-2">KES
                    <?php echo e(number_format($stats['total_disbursed'] / 1000000, 1)); ?>M</p>
                <p class="text-gray-500 text-sm mt-1">Total disbursed</p>
            </div>
        </div>

        <!-- Pending Applications - Sorted from latest -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Pending Applications (<?php echo e($pendingLoans->count()); ?>)</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingLoans->count() > 0): ?>
                <div class="space-y-4">
                    <?php
                        // Sort from most recent to oldest
                        $sortedPendingLoans = $pendingLoans->sortByDesc('created_at')->values();
                    ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sortedPendingLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-5 hover:bg-gray-50 transition">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <!-- Loan Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-bold"><?php echo e(strtoupper(substr($loan->user->name, 0, 1))); ?></span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900"><?php echo e($loan->user->name); ?></p>
                                            <p class="text-gray-600 text-sm"><?php echo e($loan->user->employee_number); ?> • <?php echo e($loan->user->department ?? 'N/A'); ?></p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4 text-sm">
                                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                            <p class="text-gray-600">Amount</p>
                                            <p class="font-bold text-green-600">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                        </div>
                                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                            <p class="text-gray-600">Period</p>
                                            <p class="font-bold text-gray-900"><?php echo e($loan->period_months); ?> months</p>
                                        </div>
                                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                            <p class="text-gray-600">Savings</p>
                                            <p class="font-bold text-blue-600">KES <?php echo e(number_format($loan->user->savings->available_savings ?? 0, 2)); ?></p>
                                        </div>
                                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                            <p class="text-gray-600">Applied</p>
                                            <p class="font-bold text-gray-900"><?php echo e($loan->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <!-- Review & Decide Button moved here -->
                                        <div class="p-3 border border-gray-200 rounded bg-gray-50 flex items-center justify-center">
                                            <a href="<?php echo e(route('chairman.loans.approve-view', $loan->id)); ?>" 
                                               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition text-center">
                                                Review & Decide
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <?php echo e($pendingLoans->links()); ?>

                </div>
            <?php else: ?>
                <div class="p-8 text-center bg-green-50 rounded-lg">
                    <p class="text-green-700 font-semibold text-lg">✓ No pending loan applications</p>
                    <p class="text-gray-600 mt-2">All applications have been processed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Recently Processed -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentlyProcessed->count() > 0): ?>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Recently Processed</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">#</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Applicant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Amount</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Processed</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentlyProcessed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border border-gray-200 text-gray-700"><?php echo e($loop->iteration); ?></td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <div>
                                            <p class="font-medium text-gray-900"><?php echo e($loan->user->name); ?></p>
                                            <p class="text-gray-500 text-sm"><?php echo e($loan->user->employee_number); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'approved'): ?>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✓ Approved</span>
                                        <?php elseif($loan->status === 'rejected'): ?>
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">✗ Rejected</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-gray-600 text-sm"><?php echo e($loan->approved_date ? $loan->approved_date->format('d M Y H:i') : 'N/A'); ?></td>
                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="<?php echo e(route('chairman.loans.approve-view', $loan->id)); ?>" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/chairman/loan-approvals.blade.php ENDPATH**/ ?>