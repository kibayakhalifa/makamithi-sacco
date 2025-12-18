

<?php $__env->startSection('title', 'Treasurer Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Treasurer Dashboard</h1>
                    <p class="text-gray-500 text-sm md:text-base mt-1">
                        Welcome back, <?php echo e(auth()->user()->name); ?> — manage all financial operations.
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
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">KES
                            <?php echo e(number_format($stats['total_savings'] ?? 0, 2)); ?></p>
                    </div>
                    <div class="text-2xl">💰</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="<?php echo e(route('treasurer.savings')); ?>"
                        class="text-green-600 hover:text-green-700 text-xs font-medium">
                        View savings →
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">KES
                            <?php echo e(number_format($stats['active_loans'] ?? 0, 2)); ?></p>
                    </div>
                    <div class="text-2xl">📝</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="<?php echo e(route('treasurer.loans')); ?>" class="text-blue-600 hover:text-blue-700 text-xs font-medium">
                        Manage loans →
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Pending Actions</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900"><?php echo e($stats['pending_cheques'] ?? 0); ?></p>
                    </div>
                    <div class="text-2xl">⏳</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="<?php echo e(route('treasurer.cheques')); ?>"
                        class="text-orange-600 hover:text-orange-700 text-xs font-medium">
                        Take action →
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Cash at Bank</p>
                        <p class="text-2xl font-semibold mt-1 text-gray-900">KES
                            <?php echo e(number_format($stats['cash_at_bank'] ?? 0, 2)); ?></p>
                    </div>
                    <div class="text-2xl">🏦</div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="<?php echo e(route('treasurer.reconciliation')); ?>"
                        class="text-purple-600 hover:text-purple-700 text-xs font-medium">
                        Reconcile →
                    </a>
                </div>
            </div>
        </div>

        <!-- Financial Operations - Adjusted grid -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">Financial Operations</h2>
                    <p class="text-gray-500 text-sm">Core treasury functions</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 bg-green-100 text-green-800 rounded-full">7 Functions</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                <!-- Payment Processing -->
                <a href="<?php echo e(route('treasurer.payments')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-700 text-sm">💳</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-700">Payments</h3>
                                <p class="text-gray-500 text-xs">Disbursements</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium">
                                KES <?php echo e(number_format($stats['pending_payments'] ?? 0, 2)); ?> pending
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Loans Management -->
                <a href="<?php echo e(route('treasurer.loans')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-700 text-sm">📊</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-blue-700">Loans</h3>
                                <p class="text-gray-500 text-xs">Portfolio</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-blue-600 text-xs font-medium">
                                KES <?php echo e(number_format($stats['active_loans'] ?? 0, 2)); ?> active
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Savings Summary -->
                <a href="<?php echo e(route('treasurer.savings')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-700 text-sm">🏦</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-700">Savings</h3>
                                <p class="text-gray-500 text-xs">Accounts</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium">
                                <?php echo e($stats['total_members'] ?? 0); ?> members
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Expenses Tracking -->
                <a href="<?php echo e(route('treasurer.expenses')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-orange-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="text-orange-700 text-sm">📋</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-orange-700">Expenses</h3>
                                <p class="text-gray-500 text-xs">Costs</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-orange-600 text-xs font-medium">
                                <?php echo e($stats['pending_expenses'] ?? 0); ?> pending
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Cheque Management -->
                <a href="<?php echo e(route('treasurer.cheques')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-700 text-sm">🏦</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-700">Cheques</h3>
                                <p class="text-gray-500 text-xs">Management</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium">
                                <?php echo e($stats['pending_cheques'] ?? 0); ?> to issue
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Bank Reconciliation -->
                <a href="<?php echo e(route('treasurer.reconciliation')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-700 text-sm">✅</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-blue-700">Reconciliation
                                </h3>
                                <p class="text-gray-500 text-xs">Bank vs system</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-blue-600 text-xs font-medium">
                                Last: Today
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Financial Reports -->
                <a href="<?php echo e(route('treasurer.financial-reports')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="text-purple-700 text-sm">📊</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-purple-700">Reports</h3>
                                <p class="text-gray-500 text-xs">Generate</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100">
                            <span class="text-purple-600 text-xs font-medium">
                                4 templates
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Transactions - Excel-like table -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Recent Transactions</h2>
                <a href="<?php echo e(route('treasurer.payments')); ?>"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTransactions && count($recentTransactions) > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    #
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Type
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Member
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Amount
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Date
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentTransactions->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex items-center gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type === 'deposit' || $transaction->type === 'loan_payment'): ?>
                                                <span class="text-green-600 text-sm">💵</span>
                                            <?php elseif($transaction->type === 'withdrawal'): ?>
                                                <span class="text-orange-600 text-sm">🏧</span>
                                            <?php else: ?>
                                                <span class="text-blue-600 text-sm">💳</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <span
                                                class="text-sm text-gray-900"><?php echo e(ucwords(str_replace('_', ' ', $transaction->type ?? 'payment'))); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p class="font-medium">
                                                <?php echo e($transaction->loan->user->name ?? $transaction->user->name ?? 'System'); ?></p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo e($transaction->loan->user->employee_number ?? 'N/A'); ?></p>
                                        </div>
                                    </td>
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        KES <?php echo e(number_format($transaction->amount, 2)); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                        <div>
                                            <p><?php echo e($transaction->payment_date?->format('d M Y') ?? $transaction->created_at->format('d M Y')); ?>

                                            </p>
                                            <p class="text-xs text-gray-400">
                                                <?php echo e($transaction->payment_date?->format('h:i A') ?? $transaction->created_at->format('h:i A')); ?>

                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-orange-100 text-orange-800 border border-orange-200'); ?>">
                                            <?php echo e(ucfirst($transaction->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-8 border border-gray-300 rounded-lg">
                    <div class="text-3xl mb-3">📊</div>
                    <h4 class="text-base font-medium text-gray-900 mb-1">No Recent Transactions</h4>
                    <p class="text-gray-500 text-sm">Transaction history will appear here</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Quick Actions & Upcoming Payments -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Payments -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Payments</h3>
                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                        Next 7 Days
                    </span>
                </div>

                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingDeadlines && count($upcomingDeadlines) > 0): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcomingDeadlines->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                        <span class="text-blue-600 text-sm">👤</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm"><?php echo e($loan->user->name ?? 'Member'); ?></p>
                                        <p class="text-gray-500 text-xs">Loan #<?php echo e($loan->id); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 text-sm">KES
                                        <?php echo e(number_format($loan->remaining_balance ?? $loan->amount, 2)); ?></p>
                                    <p class="text-orange-600 text-xs font-medium">
                                        <?php echo e($loan->next_payment_date?->format('M d') ?? 'Soon'); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm">No upcoming payments</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>

                <div class="grid grid-cols-2 gap-3">
                    <a href="<?php echo e(route('treasurer.payments')); ?>"
                        class="flex items-center justify-center gap-2 bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition text-sm">
                        <span>💳</span>
                        <span>Process Payments</span>
                    </a>

                    <a href="<?php echo e(route('treasurer.savings')); ?>"
                        class="flex items-center justify-center gap-2 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                        <span>🏦</span>
                        <span>Manage Savings</span>
                    </a>

                    <a href="<?php echo e(route('treasurer.financial-reports')); ?>"
                        class="flex items-center justify-center gap-2 bg-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-purple-700 transition text-sm">
                        <span>📊</span>
                        <span>Generate Report</span>
                    </a>

                    <a href="<?php echo e(route('treasurer.reconciliation')); ?>"
                        class="flex items-center justify-center gap-2 bg-orange-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-700 transition text-sm">
                        <span>✅</span>
                        <span>Reconcile Accounts</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/dashboard.blade.php ENDPATH**/ ?>