

<?php $__env->startSection('title', 'Treasurer Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 font-sans">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Treasurer Dashboard</h1>
                    <p class="text-green-800 mt-1">Welcome, <?php echo e(auth()->user()->name); ?> — Manage all financial operations</p>
                </div>
                <div class="text-right">
                    <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                        <p class="text-green-600 text-sm font-medium">Total Savings (Members)</p>
                        <p class="text-4xl font-bold text-gray-900">KES <?php echo e(number_format($stats['total_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-xs mt-1">From <?php echo e($stats['total_members']); ?> members</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['total_savings'], 2)); ?>

                        </p>
                        <div class="flex items-center mt-1">
                            <span class="text-green-600 text-sm font-medium">💾</span>
                            <span class="text-gray-500 text-xs ml-2">Members' funds</span>
                        </div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Loans</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['active_loans'], 2)); ?>

                        </p>
                        <div class="flex items-center mt-1">
                            <span class="text-blue-600 text-sm font-medium">📈</span>
                            <span class="text-gray-500 text-xs ml-2">Being repaid</span>
                        </div>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">📝</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Cheques</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['pending_cheques']); ?></p>
                        <div class="flex items-center mt-1">
                            <span class="text-orange-600 text-sm font-medium">⏳</span>
                            <span class="text-gray-500 text-xs ml-2">To process</span>
                        </div>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">📋</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Cash at Bank</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['cash_at_bank'], 2)); ?>

                        </p>
                        <div class="flex items-center mt-1">
                            <span class="text-green-600 text-sm font-medium">✅</span>
                            <span class="text-gray-500 text-xs ml-2">Available</span>
                        </div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">🏦</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7-Key Treasurer Reports -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        <span class="text-green-600">📋</span> Treasurer's 7-Key Reports
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Click any section to manage</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 bg-green-100 text-green-800 rounded-full">1-7 Numbered</span>
                    <span class="text-xs px-3 py-1 bg-orange-100 text-orange-800 rounded-full">Green+Orange Theme</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <!-- 1. Payment Processing -->
                <a href="<?php echo e(route('treasurer.payments')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                <span class="text-orange-700 font-bold text-lg">1</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-700">Payment Processing</h3>
                                <p class="text-gray-500 text-xs">Disbursements & transfers</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pending Payments:</span>
                                <span
                                    class="font-semibold text-orange-600"><?php echo e($stats['pending_payments'] > 0 ? 'KES ' . number_format($stats['pending_payments'], 2) : '0'); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pending Cheques:</span>
                                <span class="font-semibold"><?php echo e($stats['pending_cheques']); ?> to issue</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Cash at Bank:</span>
                                <span class="font-semibold text-gray-900">KES
                                    <?php echo e(number_format($stats['cash_at_bank'], 2)); ?></span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> View Payments
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 2. Loans Management -->
                <a href="<?php echo e(route('treasurer.loans')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <span class="text-green-700 font-bold text-lg">2</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-700">Loans Management</h3>
                                <p class="text-gray-500 text-xs">Approved & pending loans</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Active Loans:</span>
                                <span class="font-semibold text-gray-900">KES
                                    <?php echo e(number_format($stats['active_loans'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pending Approval:</span>
                                <span class="font-semibold text-orange-600">Multiple awaiting</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Active:</span>
                                <span class="font-semibold text-gray-900">KES <?php echo e(number_format($stats['active_loans'], 2)); ?></span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> Manage Loans
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 3. Savings Summary -->
                <a href="<?php echo e(route('treasurer.savings')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <span class="text-green-700 font-bold text-lg">3</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-700">Savings Summary</h3>
                                <p class="text-gray-500 text-xs">Member savings & withdrawals</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Savings:</span>
                                <span class="font-semibold text-gray-900">KES
                                    <?php echo e(number_format($stats['total_savings'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Members:</span>
                                <span class="font-semibold"><?php echo e($stats['total_members']); ?> accounts</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Withdrawals:</span>
                                <span class="font-semibold text-orange-600">Pending approval</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> View Savings
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 4. Expenses Tracking -->
                <a href="<?php echo e(route('treasurer.expenses')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-orange-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                <span class="text-orange-700 font-bold text-lg">4</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-orange-700">Expenses Tracking</h3>
                                <p class="text-gray-500 text-xs">Sacco operational costs</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pending Expenses:</span>
                                <span class="font-semibold text-orange-600"><?php echo e($stats['pending_expenses'] ?? 0); ?>

                                    pending</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Operational Costs:</span>
                                <span class="font-semibold text-gray-900">Active tracking</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Categories:</span>
                                <span class="font-semibold">Multiple tracked</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-orange-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> Track Expenses
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 5. Cheque Management -->
                <a href="<?php echo e(route('treasurer.cheques')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <span class="text-green-700 font-bold text-lg">5</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-700">Cheque Management</h3>
                                <p class="text-gray-500 text-xs">Issue & clearance</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">To Issue:</span>
                                <span class="font-semibold text-orange-600"><?php echo e($stats['pending_cheques']); ?> cheques</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-semibold text-gray-900">Active tracking</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Clearance:</span>
                                <span class="font-semibold">In progress</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> Manage Cheques
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 6. Bank Reconciliation -->
                <a href="<?php echo e(route('treasurer.reconciliation')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <span class="text-green-700 font-bold text-lg">6</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-green-700">Bank Reconciliation</h3>
                                <p class="text-gray-500 text-xs">Bank vs system records</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Last Recon:</span>
                                <span class="font-semibold text-gray-900">Yesterday</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Difference:</span>
                                <span class="font-semibold text-green-600">KES 0.00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-semibold px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Balanced
                                    ✓</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> Reconcile Now
                            </span>
                        </div>
                    </div>
                </a>

                <!-- 7. Financial Reports -->
                <a href="<?php echo e(route('treasurer.financial-reports')); ?>" class="group">
                    <div
                        class="border border-gray-200 rounded-xl p-5 hover:border-orange-300 hover:shadow-lg transition-all duration-200 bg-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                <span class="text-orange-700 font-bold text-lg">7</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 group-hover:text-orange-700">Financial Reports</h3>
                                <p class="text-gray-500 text-xs">Generate & export reports</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">This Month:</span>
                                <span class="font-semibold text-gray-900">4 reports</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Due Today:</span>
                                <span class="font-semibold text-orange-600">Monthly Report</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Formats:</span>
                                <span class="font-semibold">PDF, Excel, CSV</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <span class="text-orange-600 text-xs font-medium flex items-center gap-1">
                                <span>→</span> Generate Reports
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Summary Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-4 rounded-xl">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-600">✓</span>
                            </div>
                            <div>
                                <p class="text-sm text-green-800 font-medium">All Systems Operational</p>
                                <p class="text-xs text-green-600">Last checked: 5 mins ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-xl">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="text-orange-600">⏳</span>
                            </div>
                            <div>
                                <p class="text-sm text-orange-800 font-medium">Action Required</p>
                                <p class="text-xs text-orange-600">15 pending items</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                <span class="text-gray-600">📊</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800 font-medium">Overall Health</p>
                                <p class="text-xs text-gray-600">94% positive metrics</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                    <a href="#" class="text-green-600 text-sm font-medium hover:text-green-700">View All →</a>
                </div>

                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTransactions && count($recentTransactions) > 0): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg flex items-center justify-center 
                                                    <?php echo e($transaction->status === 'completed' ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-600'); ?>">
                                        <span class="text-lg">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type === 'deposit'): ?>
                                                💰
                                            <?php elseif($transaction->type === 'withdrawal'): ?>
                                                🏧
                                            <?php else: ?>
                                                💳
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            <?php echo e(ucwords(str_replace('_', ' ', $transaction->type))); ?></p>
                                        <p class="text-gray-500 text-sm"><?php echo e($transaction->user->name ?? 'System'); ?></p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-gray-900">
                                        <?php echo e($transaction->type === 'withdrawal' ? '-' : ''); ?>KES
                                        <?php echo e(number_format($transaction->amount, 2)); ?>

                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        <?php echo e($transaction->transaction_date?->format('M d, g:i A') ?? 'Unknown date'); ?></p>
                                    <span
                                        class="inline-block mt-1 px-2 py-1 text-xs rounded-full 
                                                    <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'); ?>">
                                        <?php echo e(ucfirst($transaction->status)); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-gray-500">
                            <p class="text-sm">No recent transactions</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>

                <div class="space-y-3">
                    <a href="<?php echo e(route('treasurer.payments')); ?>"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                        <span>💳</span> Process Payments
                    </a>

                    <button onclick="recordDeposit()"
                        class="w-full bg-green-50 hover:bg-green-100 text-green-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                        <span>💰</span> Record Bank Deposit
                    </button>

                    <button onclick="generateReport()"
                        class="w-full bg-orange-50 hover:bg-orange-100 text-orange-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                        <span>📊</span> Daily Report
                    </button>

                    <button onclick="checkReconciliation()"
                        class="w-full bg-gray-50 hover:bg-gray-100 text-gray-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                        <span>✅</span> Quick Reconciliation
                    </button>

                    <button onclick="viewAuditTrail()"
                        class="w-full bg-gray-50 hover:bg-gray-100 text-gray-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                        <span>👁️</span> View Audit Trail
                    </button>
                </div>

                <!-- Upcoming Deadlines -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-3">Upcoming Loan Payments</h4>
                    <div class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingDeadlines && count($upcomingDeadlines) > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcomingDeadlines->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <p class="text-gray-600"><?php echo e($loan->user->name ?? 'Unknown'); ?></p>
                                        <p class="text-gray-500 text-xs">Loan #<?php echo e($loan->id); ?>: KES
                                            <?php echo e(number_format($loan->remaining_balance, 2)); ?></p>
                                    </div>
                                    <span
                                        class="text-orange-600 font-medium"><?php echo e($loan->next_payment_date?->format('M d') ?? 'N/A'); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">No upcoming payments</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript for Quick Actions -->
    <script>
        function recordDeposit() {
            const amount = prompt('Enter deposit amount (KES):');
            if (amount && !isNaN(amount)) {
                alert(`Recording deposit of KES ${parseFloat(amount).toLocaleString()}...`);
                // AJAX call here
            }
        }

        function generateReport() {
            alert('Generating daily financial report...');
            // AJAX call here
        }

        function checkReconciliation() {
            alert('Checking bank reconciliation status...');
            // AJAX call here
        }

        function viewAuditTrail() {
            alert('Opening audit trail view...');
            // AJAX call here
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/dashboard.blade.php ENDPATH**/ ?>