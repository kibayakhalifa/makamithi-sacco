<?php $__env->startSection('title', 'Savings Summary'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-green-700 font-bold">💰</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Savings Summary</h1>
                        <p class="text-gray-500 text-sm md:text-base">Manage member savings accounts, withdrawals, and payroll deductions</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Total Member Savings</p>
                    <p class="text-3xl font-bold text-gray-900">KES <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($savingsStats['total_members']); ?> members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1"><?php echo e($savingsStats['total_members']); ?> accounts</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">💰</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Avg. Savings</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($savingsStats['average_savings'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Per member</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">📊</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Withdrawals</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($savingsStats['pending_withdrawals']); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting processing</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Monthly Deductions</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($savingsStats['monthly_deductions'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">From payroll</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">📄</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('accounts')" id="accountsTab"
                    class="px-6 py-4 font-medium border-b-2 border-green-600 text-green-700 whitespace-nowrap">
                    👥 All Accounts (<?php echo e($savingsAccounts->count()); ?>)
                </button>
                <button onclick="switchTab('withdrawals')" id="withdrawalsTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    💰 Withdrawal Requests (<?php echo e($withdrawalRequests->count()); ?>)
                </button>
                <button onclick="switchTab('transactions')" id="transactionsTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📊 Recent Transactions (<?php echo e($recentTransactions->count()); ?>)
                </button>
                <button onclick="switchTab('topsavers')" id="topsaversTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    🏆 Top Savers (<?php echo e($topSavers->count()); ?>)
                </button>
            </nav>
        </div>

        <!-- All Accounts -->
        <div id="accountsContent" class="p-6">
            <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <h3 class="text-lg font-semibold text-gray-900">Member Savings Accounts</h3>
                <div class="relative">
                    <input type="text" id="searchAccounts" placeholder="Search members..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-full md:w-64">
                    <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($savingsAccounts->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Account</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Available Savings</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Total Deposits</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $savingsAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e(($savingsAccounts->currentPage() - 1) * $savingsAccounts->perPage() + $index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($account->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($account->user->name); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($account->user->employee_number); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($account->user->department ?? 'N/A'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>#<?php echo e($account->account_number); ?></p>
                                            <p class="text-gray-500 text-xs">Opened: <?php echo e($account->created_at->format('d M Y')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <p class="font-bold text-green-600">KES <?php echo e(number_format($account->available_savings, 2)); ?></p>
                                        <p class="text-gray-500 text-xs">Available for withdrawal</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <p class="font-medium text-gray-900">KES <?php echo e(number_format($account->total_deposits, 2)); ?></p>
                                        <p class="text-gray-500 text-xs">Lifetime deposits</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="viewAccount(<?php echo e($account->id); ?>)"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                View
                                            </button>
                                            <button onclick="recordDeposit(<?php echo e($account->id); ?>)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Deposit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($savingsAccounts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">👤</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Savings Accounts</h3>
                    <p class="text-gray-500">Member savings accounts will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Withdrawal Requests -->
        <div id="withdrawalsContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withdrawalRequests->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Request Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Available Balance</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Request Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $withdrawalRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($request->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($request->transaction_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($request->description); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($request->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($request->user->name); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($request->user->employee_number); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($request->user->phone ?? 'No phone'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p class="font-medium text-gray-900">KES <?php echo e(number_format($request->user->savings->available_savings ?? 0, 2)); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->amount > ($request->user->savings->available_savings ?? 0)): ?>
                                                <p class="text-red-600 text-xs">Insufficient funds!</p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p><?php echo e($request->created_at->format('d M Y')); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($request->created_at->format('h:i A')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <form action="<?php echo e(route('treasurer.withdrawals.process', $request->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="payment_method" value="bank_transfer">
                                                <button type="submit" onclick="return confirm('Process this withdrawal request?');"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium w-full sm:w-auto">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('treasurer.withdrawals.reject', $request->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" onclick="return confirm('Reject this withdrawal request?');"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-medium w-full sm:w-auto">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Withdrawals</h3>
                    <p class="text-gray-500">All withdrawal requests have been processed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Recent Transactions -->
        <div id="transactionsContent" class="p-6 hidden">
            <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <h3 class="text-lg font-semibold text-gray-900">Recent Savings Transactions</h3>
                <button onclick="exportTransactions()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                    Export CSV
                </button>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTransactions->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Transaction</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-medium text-gray-900 text-sm">#<?php echo e($transaction->transaction_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($transaction->description); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($transaction->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($transaction->user->name); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($transaction->user->employee_number); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <p class="font-bold <?php echo e($transaction->type === 'withdrawal' ? 'text-red-600' : 'text-green-600'); ?>">
                                            <?php echo e($transaction->type === 'withdrawal' ? '-' : '+'); ?>KES <?php echo e(number_format($transaction->amount, 2)); ?>

                                        </p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span class="px-2 py-1 text-xs rounded-full font-medium border <?php echo e($transaction->type === 'deposit' ? 'bg-green-100 text-green-800 border-green-200' :
                                            ($transaction->type === 'withdrawal' ? 'bg-red-100 text-red-800 border-red-200' :
                                            'bg-blue-100 text-blue-800 border-blue-200')); ?>">
                                            <?php echo e(ucfirst($transaction->type)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p><?php echo e($transaction->transaction_date->format('d M Y')); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($transaction->transaction_date->format('h:i A')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span class="px-2 py-1 text-xs rounded-full font-medium border <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800 border-green-200' :
                                            ($transaction->status === 'pending' ? 'bg-orange-100 text-orange-800 border-orange-200' :
                                            'bg-red-100 text-red-800 border-red-200')); ?>">
                                            <?php echo e(ucfirst($transaction->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Recent Transactions</h3>
                    <p class="text-gray-500">Transaction history will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Top Savers -->
        <div id="topsaversContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topSavers->count() > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topSavers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-green-700 font-bold text-sm"><?php echo e($index + 1); ?></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm"><?php echo e($account->user->name); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($account->user->employee_number); ?></p>
                                    </div>
                                </div>
                                <span class="text-xl">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index === 0): ?> 🥇
                                    <?php elseif($index === 1): ?> 🥈
                                    <?php elseif($index === 2): ?> 🥉
                                    <?php else: ?> 🏅
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-xs">Total Savings:</span>
                                    <span class="font-bold text-green-600 text-sm">KES <?php echo e(number_format($account->available_savings, 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-xs">Total Deposits:</span>
                                    <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($account->total_deposits, 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-xs">Withdrawals:</span>
                                    <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($account->total_withdrawn, 2)); ?></span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <button onclick="viewAccount(<?php echo e($account->id); ?>)"
                                    class="w-full bg-green-50 hover:bg-green-100 text-green-800 py-2 rounded-lg text-xs font-medium">
                                    View Account Details
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">🏆</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Top Savers</h3>
                    <p class="text-gray-500">Top savers will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions & Reports -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button onclick="uploadPayroll()"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📄</span> Upload Payroll Deductions
                </button>
                <button onclick="processAllWithdrawals()"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>💰</span> Process All Withdrawals (<?php echo e($withdrawalRequests->count()); ?>)
                </button>
                <button onclick="addInterest()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📈</span> Add Monthly Interest
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Savings Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('summary')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📊 Savings Summary Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('monthly')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📈 Monthly Performance</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('projection')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>🔮 Savings Projection</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportSavingsData()"
                    class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center border border-green-200">
                    <span>💾 Export All Savings Data</span>
                    <span class="text-green-600">→</span>
                </button>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        ['accounts', 'withdrawals', 'transactions', 'topsavers'].forEach(tab => {
            document.getElementById(tab + 'Content').classList.add('hidden');
            document.getElementById(tab + 'Tab').classList.remove('border-b-2', 'border-green-600', 'text-green-700');
            document.getElementById(tab + 'Tab').classList.add('text-gray-500');
        });

        // Show selected content
        document.getElementById(tabName + 'Content').classList.remove('hidden');

        // Activate selected tab
        document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-green-600', 'text-green-700');
        document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
    }

    // Action functions
    function viewAccount(accountId) {
        window.location.href = `/savings/accounts/${accountId}`;
    }

    function recordDeposit(accountId) {
        const amount = prompt('Enter deposit amount (KES):');
        if (amount && !isNaN(amount)) {
            const description = prompt('Description (optional):');
            window.location.href = `/savings/accounts/${accountId}/deposit?amount=${amount}&description=${encodeURIComponent(description || '')}`;
        }
    }

    function processAllWithdrawals() {
        const count = <?php echo e($withdrawalRequests->count()); ?>;
        if (count > 0 && confirm(`Process all ${count} withdrawal requests?`)) {
            fetch('/treasurer/withdrawals/process-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Processed ${data.count} withdrawals successfully!`);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        }
    }

    function addInterest() {
        const rate = prompt('Enter interest rate (%):', '2.5');
        if (rate && !isNaN(rate)) {
            if (confirm(`Add ${rate}% interest to all savings accounts?`)) {
                fetch('/treasurer/savings/add-interest', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ rate: rate })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Interest added successfully! Total: KES ' + data.total_interest.toLocaleString());
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }
    }

    function generateReport(type) {
        window.location.href = `/treasurer/reports/savings/${type}`;
    }

    function exportSavingsData() {
        if (confirm('Export all savings data to Excel?')) {
            window.location.href = '/treasurer/savings/export';
        }
    }

    function exportTransactions() {
        if (confirm('Export transaction history to CSV?')) {
            window.location.href = '/treasurer/savings/transactions/export';
        }
    }

    function uploadPayroll() {
        window.location.href = '/treasurer/payroll/upload';
    }

    // Search functionality
    document.getElementById('searchAccounts')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#accountsContent tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('accounts');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/savings.blade.php ENDPATH**/ ?>