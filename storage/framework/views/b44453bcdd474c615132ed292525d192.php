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
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-blue-700 font-medium">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-blue-900">
                            KES <?php echo e(number_format($stats['total_savings'] ?? 0, 2)); ?>

                        </p>
                        <p class="text-xs text-blue-600 mt-1">Available for loans</p>
                    </div>
                    <div class="text-3xl text-blue-500">💰</div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-green-700 font-medium">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-green-900"><?php echo e($stats['active_loans_count'] ?? 0); ?></p>
                        <p class="text-xs text-green-600 mt-1">Currently active</p>
                    </div>
                    <div class="text-3xl text-green-500">📄</div>
                </div>
            </div>

            <!-- Loan Balance -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-purple-700 font-medium">Loan Balance</p>
                        <p class="text-3xl font-semibold mt-2 text-purple-900">
                            KES <?php echo e(number_format($stats['total_loan_balance'] ?? 0, 2)); ?>

                        </p>
                        <p class="text-xs text-purple-600 mt-1">Outstanding amount</p>
                    </div>
                    <div class="text-3xl text-purple-500">💸</div>
                </div>
            </div>

            <!-- Withdrawable Amount -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-orange-700 font-medium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->sacco_status === 'active'): ?>
                                Loan Eligibility
                            <?php else: ?>
                                Withdrawable
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                        <p class="text-3xl font-semibold mt-2 text-orange-900">
                            KES <?php echo e(number_format($stats['loan_eligibility'] ?? 0, 2)); ?>

                        </p>
                        <p class="text-xs text-orange-600 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->sacco_status === 'active'): ?>
                                For new loans (1.5× savings)
                            <?php else: ?>
                                Available to withdraw
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                    <div class="text-3xl text-orange-500">🏦</div>
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

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTransactions && $recentTransactions->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Transaction ID</th>
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
                                    <p class="font-medium text-gray-900"><?php echo e($transaction->transaction_date ? $transaction->transaction_date->format('d M Y') : $transaction->created_at->format('d M Y')); ?></p>
                                    <p class="text-gray-500 text-xs"><?php echo e($transaction->created_at->diffForHumans()); ?></p>
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300">
                                    <?php echo e($transaction->transaction_ref ?? 'TRX-' . $transaction->id); ?>

                                </td>

                                <td class="px-6 py-4 font-semibold border-r border-gray-300 <?php echo e($transaction->type !== 'withdrawal' ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($transaction->type !== 'withdrawal' ? '+' : '-'); ?>KES <?php echo e(number_format(abs($transaction->amount), 2)); ?>

                                </td>

                                <td class="px-6 py-4 border-r border-gray-300">
                                    <span class="text-gray-700">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type === 'payroll_deduction'): ?>
                                            Payroll Deduction
                                        <?php elseif($transaction->type === 'voluntary_deposit'): ?>
                                            Voluntary Deposit
                                        <?php elseif($transaction->type === 'interest_credit'): ?>
                                            Interest Credit
                                        <?php elseif($transaction->type === 'withdrawal'): ?>
                                            Withdrawal
                                        <?php else: ?>
                                            <?php echo e(ucfirst(str_replace('_', ' ', $transaction->type ?? 'deposit'))); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
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
                                            ✗ <?php echo e(ucfirst($transaction->status ?? 'unknown')); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <div class="text-5xl mb-4 text-gray-400">💰</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No Recent Transactions</h3>
                <p class="text-gray-500 mb-6">You haven't made any savings transactions yet.</p>
                <a href="<?php echo e(route('member.savings.index')); ?>"
                    class="inline-block px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    View Savings Account
                </a>
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
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <div class="text-5xl mb-4 text-gray-400">📋</div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Loans Applied Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't applied for any loans yet.</p>
                    <a href="<?php echo e(route('member.loans.apply')); ?>"
                        class="inline-block px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for Your First Loan
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

                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <span class="px-2 py-1 text-xs font-medium rounded <?php echo e($loan->loan_type === 'first_loan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                            <?php echo e($loan->loan_type === 'first_loan' ? 'First Loan' : 'Second Loan'); ?>

                                        </span>
                                    </td>

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
                                        <?php elseif($loan->status === 'disbursed' || $loan->status === 'active'): ?>
                                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                                <?php echo e(ucfirst($loan->status)); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition inline-flex items-center">
                                            View Details 
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-blue-900 mb-6">Quick Actions</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="<?php echo e(route('member.loans.apply')); ?>"
                    class="bg-white border border-blue-300 rounded-xl p-4 text-center hover:bg-blue-50 transition group">
                    <div class="text-3xl text-blue-600 mb-2">📝</div>
                    <h4 class="font-semibold text-blue-900 group-hover:text-blue-700">Apply for Loan</h4>
                    <p class="text-sm text-gray-600 mt-1">Get quick access to funds</p>
                </a>

                <a href="<?php echo e(route('member.savings.index')); ?>"
                    class="bg-white border border-green-300 rounded-xl p-4 text-center hover:bg-green-50 transition group">
                    <div class="text-3xl text-green-600 mb-2">💰</div>
                    <h4 class="font-semibold text-green-900 group-hover:text-green-700">View Savings</h4>
                    <p class="text-sm text-gray-600 mt-1">Check your savings balance</p>
                </a>

                <a href="<?php echo e(route('member.loans.index')); ?>"
                    class="bg-white border border-purple-300 rounded-xl p-4 text-center hover:bg-purple-50 transition group">
                    <div class="text-3xl text-purple-600 mb-2">📊</div>
                    <h4 class="font-semibold text-purple-900 group-hover:text-purple-700">Loan Statements</h4>
                    <p class="text-sm text-gray-600 mt-1">View loan repayment history</p>
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/dashboard.blade.php ENDPATH**/ ?>