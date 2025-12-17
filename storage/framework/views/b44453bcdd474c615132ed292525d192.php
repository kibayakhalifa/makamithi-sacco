<?php $__env->startSection('title', 'Member Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Dashboard</h1>
                    <p class="text-gray-500 mt-1">
                        Welcome <?php echo e(auth()->user()->name); ?> — here is an overview of your savings and loan status.
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-xl font-semibold text-gray-800"><?php echo e(now()->format('d M Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Savings -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES <?php echo e(number_format($stats['total_savings'] ?? 0, 2)); ?>

                        </p>
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900"><?php echo e($stats['active_loans_count'] ?? 0); ?></p>
                    </div>
                    <div class="text-3xl">📄</div>
                </div>
            </div>

            <!-- Loan Balance -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Loan Balance</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES <?php echo e(number_format($stats['total_loan_balance'] ?? 0, 2)); ?>

                        </p>
                    </div>
                    <div class="text-3xl">💸</div>
                </div>
            </div>

            <!-- Withdrawable Amount -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Withdrawable</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES <?php echo e(number_format($stats['withdrawable_amount'] ?? 0, 2)); ?>

                        </p>
                    </div>
                    <div class="text-3xl">🏦</div>
                </div>
            </div>
        </div>

        <!-- Recent Savings Activity -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Recent Savings Activity</h2>
                <a href="<?php echo e(route('member.savings.index')); ?>"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTransactions->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Amount</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Type</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <p class="font-medium text-gray-900"><?php echo e($transaction->transaction_date?->format('d M Y') ?? $transaction->created_at->format('d M Y')); ?></p>
                                    <p class="text-gray-500 text-xs"><?php echo e($transaction->transaction_date?->diffForHumans() ?? $transaction->created_at->diffForHumans()); ?></p>
                                </td>

                                <td class="px-6 py-4 font-semibold border-r border-gray-300 <?php echo e($transaction->amount > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($transaction->amount > 0 ? '+' : ''); ?>KES <?php echo e(number_format(abs($transaction->amount), 2)); ?>

                                </td>

                                <td class="px-6 py-4 border-r border-gray-300">
                                    <span class="text-gray-700"><?php echo e(ucfirst(str_replace('_', ' ', $transaction->type))); ?></span>
                                </td>

                                <td class="px-6 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status === 'completed'): ?>
                                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                            ✓ Completed
                                        </span>
                                    <?php elseif($transaction->status === 'pending'): ?>
                                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                            ⏳ Pending
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                            ✗ <?php echo e(ucfirst($transaction->status)); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No transactions yet</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- My Loans Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">My Loans</h2>
                <a href="<?php echo e(route('member.loans.apply')); ?>"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                    + Apply New Loan
                </a>
            </div>

            <?php
                $userLoans = auth()->user()->loans()->orderBy('applied_date', 'desc')->get();
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userLoans->isEmpty()): ?>
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No loans applied yet</p>
                    <a href="<?php echo e(route('member.loans.apply')); ?>"
                        class="inline-block mt-4 px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for a Loan Now
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-300 bg-gray-50">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Loan Number</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Type</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Amount</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Applied Date</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Status</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $userLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300"><?php echo e($index + 1); ?></td>

                                    <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300"><?php echo e($loan->loan_number); ?></td>

                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300"><?php echo e($loan->loan_type ?? 'Standard'); ?></td>

                                    <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300">
                                        KES <?php echo e(number_format($loan->amount, 2)); ?>

                                    </td>

                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                        <?php echo e($loan->applied_date->format('d M Y')); ?>

                                    </td>

                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'pending'): ?>
                                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                                Pending
                                            </span>
                                        <?php elseif($loan->status === 'approved'): ?>
                                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                                Approved
                                            </span>
                                        <?php elseif($loan->status === 'rejected'): ?>
                                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                                Rejected
                                            </span>
                                        <?php elseif($loan->status === 'disbursed'): ?>
                                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                                Disbursed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                                <?php echo e(ucfirst($loan->status)); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                            View Details →
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Loans + Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Active Loans</h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeLoans->count() > 0): ?>
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        KES <?php echo e(number_format($loan->remaining_balance, 2)); ?>

                                    </p>
                                    <p class="text-gray-500 text-xs"><?php echo e($loan->loan_number); ?> • Applied: <?php echo e($loan->applied_date->format('d M Y')); ?></p>
                                </div>

                                <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                    Active
                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">No active loans</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                <div class="space-y-3">
                    <a href="<?php echo e(route('member.loans.apply')); ?>"
                        class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                        📝 Apply for a Loan
                    </a>

                    <a href="<?php echo e(route('member.savings.index')); ?>"
                        class="w-full flex items-center justify-center gap-2 bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">
                        💰 View Savings
                    </a>

                    <button
                        class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-800 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        📄 Download Statement
                    </button>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/dashboard.blade.php ENDPATH**/ ?>