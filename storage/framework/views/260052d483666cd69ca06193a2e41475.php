

<?php $__env->startSection('title', 'Savings Summary'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 font-sans">

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">3</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Savings Summary</h1>
                    </div>
                    <p class="text-green-800">Manage member savings accounts, withdrawals, and payroll deductions</p>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                        <p class="text-green-600 text-sm font-medium">Total Member Savings</p>
                        <p class="text-4xl font-bold text-gray-900">KES
                            <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-xs mt-1"><?php echo e($savingsStats['total_members']); ?> members</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Savings Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1"><?php echo e($savingsStats['total_members']); ?> accounts</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Avg. Savings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['average_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1">Per member</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-xl">
                        <span class="text-blue-600 text-xl">📊</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Withdrawals</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($savingsStats['pending_withdrawals']); ?></p>
                        <p class="text-gray-500 text-sm mt-1">Awaiting processing</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">⏳</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Monthly Deductions</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['monthly_deductions'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1">From payroll</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-xl">
                        <span class="text-purple-600 text-xl">📄</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
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
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Member Savings Accounts</h3>
                    <div class="relative">
                        <input type="text" id="searchAccounts" placeholder="Search members..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-64">
                        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Member</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Account</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Available Savings</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Total
                                    Deposits</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $savingsAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 font-medium">
                                                    <?php echo e(strtoupper(substr($account->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($account->user->name); ?></p>
                                                <p class="text-gray-500 text-sm"><?php echo e($account->user->employee_number); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($account->user->department ?? 'N/A'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-gray-900">#<?php echo e($account->account_number); ?></p>
                                        <p class="text-gray-500 text-xs">Opened: <?php echo e($account->created_at->format('d M Y')); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-green-600">KES
                                            <?php echo e(number_format($account->available_savings, 2)); ?></p>
                                        <p class="text-gray-500 text-xs">Available for withdrawal</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="font-medium text-gray-900">KES
                                            <?php echo e(number_format($account->total_deposits, 2)); ?></p>
                                        <p class="text-gray-500 text-xs">Lifetime deposits</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex gap-2">
                                            <button onclick="viewAccount(<?php echo e($account->id); ?>)"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                View
                                            </button>
                                            <button onclick="recordDeposit(<?php echo e($account->id); ?>)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
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
            </div>

            <!-- Withdrawal Requests -->
            <div id="withdrawalsContent" class="p-6 hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withdrawalRequests->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Request Details</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Member</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Available Balance</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Request Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $withdrawalRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-gray-900">KES <?php echo e(number_format($request->amount, 2)); ?></p>
                                            <p class="text-gray-500 text-sm">#<?php echo e($request->transaction_ref); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($request->description); ?></p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-medium text-gray-900"><?php echo e($request->user->name); ?></p>
                                            <p class="text-gray-500 text-sm"><?php echo e($request->user->employee_number); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($request->user->phone ?? 'No phone'); ?></p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-medium text-gray-900">
                                                KES <?php echo e(number_format($request->user->savings->available_savings ?? 0, 2)); ?>

                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($request->amount > ($request->user->savings->available_savings ?? 0)): ?>
                                                <p class="text-red-600 text-xs">Insufficient funds!</p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="text-gray-900"><?php echo e($request->created_at->format('d M Y')); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($request->created_at->format('h:i A')); ?></p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex gap-2">
                                                <form action="<?php echo e(route('treasurer.withdrawals.process', $request->id)); ?>"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Process this withdrawal request?');">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="payment_method" value="bank_transfer">
                                                    <button type="submit"
                                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('treasurer.withdrawals.reject', $request->id)); ?>"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Reject this withdrawal request?');">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
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
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">✅</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Withdrawals</h3>
                        <p class="text-gray-500">All withdrawal requests have been processed.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Recent Transactions -->
            <div id="transactionsContent" class="p-6 hidden">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Recent Savings Transactions</h3>
                    <button onclick="exportTransactions()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                        Export CSV
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Transaction</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Member</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Type
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50 border-b">
                                                    <td class="px-4 py-4">
                                                        <p class="font-medium text-gray-900">#<?php echo e($transaction->transaction_ref); ?></p>
                                                        <p class="text-gray-500 text-xs"><?php echo e($transaction->description); ?></p>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <p class="font-medium text-gray-900"><?php echo e($transaction->user->name); ?></p>
                                                        <p class="text-gray-500 text-xs"><?php echo e($transaction->user->employee_number); ?></p>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <p
                                                            class="font-bold <?php echo e($transaction->type === 'withdrawal' ? 'text-red-600' : 'text-green-600'); ?>">
                                                            <?php echo e($transaction->type === 'withdrawal' ? '-' : '+'); ?>KES
                                                            <?php echo e(number_format($transaction->amount, 2)); ?>

                                                        </p>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span class="px-2 py-1 text-xs rounded-full font-medium 
                                                            <?php echo e($transaction->type === 'deposit' ? 'bg-green-100 text-green-800' :
                                ($transaction->type === 'withdrawal' ? 'bg-red-100 text-red-800' :
                                    'bg-blue-100 text-blue-800')); ?>">
                                                            <?php echo e(ucfirst($transaction->type)); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <p class="text-gray-900"><?php echo e($transaction->transaction_date->format('d M Y')); ?></p>
                                                        <p class="text-gray-500 text-xs"><?php echo e($transaction->transaction_date->format('h:i A')); ?>

                                                        </p>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span class="px-2 py-1 text-xs rounded-full font-medium 
                                                            <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800' :
                                ($transaction->status === 'pending' ? 'bg-orange-100 text-orange-800' :
                                    'bg-red-100 text-red-800')); ?>">
                                                            <?php echo e(ucfirst($transaction->status)); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Savers -->
            <div id="topsaversContent" class="p-6 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topSavers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-green-700 font-bold text-lg"><?php echo e($index + 1); ?></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900"><?php echo e($account->user->name); ?></p>
                                        <p class="text-gray-500 text-sm"><?php echo e($account->user->employee_number); ?></p>
                                    </div>
                                </div>
                                <span class="text-2xl">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index === 0): ?> 🥇
                                    <?php elseif($index === 1): ?> 🥈
                                    <?php elseif($index === 2): ?> 🥉
                                    <?php else: ?> 🏅
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Savings:</span>
                                    <span class="font-bold text-green-600">KES
                                        <?php echo e(number_format($account->available_savings, 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Deposits:</span>
                                    <span class="font-medium text-gray-900">KES
                                        <?php echo e(number_format($account->total_deposits, 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Withdrawals:</span>
                                    <span class="font-medium text-gray-900">KES
                                        <?php echo e(number_format($account->total_withdrawn, 2)); ?></span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <button onclick="viewAccount(<?php echo e($account->id); ?>)"
                                    class="w-full bg-green-50 hover:bg-green-100 text-green-800 py-2 rounded-lg text-sm font-medium">
                                    View Account Details
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Reports -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button onclick="uploadPayroll()"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                        <span>📄</span> Upload Payroll Deductions
                    </button>
                    <button onclick="processAllWithdrawals()"
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                        <span>💰</span> Process All Withdrawals (<?php echo e($withdrawalRequests->count()); ?>)
                    </button>
                    <button onclick="addInterest()"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                        <span>📈</span> Add Monthly Interest
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Savings Reports</h3>
                <div class="space-y-3">
                    <button onclick="generateReport('summary')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>📊 Savings Summary Report</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="generateReport('monthly')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>📈 Monthly Performance</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="generateReport('projection')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>🔮 Savings Projection</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="exportSavingsData()"
                        class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center">
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

        function processWithdrawal(requestId) {
            if (confirm('Approve this withdrawal request?')) {
                fetch(`/treasurer/withdrawals/${requestId}/process`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Withdrawal approved and processed!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }

        function rejectWithdrawal(requestId) {
            const reason = prompt('Reason for rejection:');
            if (reason) {
                fetch(`/treasurer/withdrawals/${requestId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ reason: reason })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Withdrawal rejected.');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }

        function contactMember(userId) {
            window.location.href = `/members/${userId}/contact`;
        }

        function exportTransactions() {
            if (confirm('Export transaction history to CSV?')) {
                window.location.href = '/treasurer/savings/transactions/export';
            }
        }

        function uploadPayroll() {
            window.location.href = '/treasurer/payroll/upload';
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

        // Search functionality
        document.getElementById('searchAccounts')?.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#accountsContent tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function () {
            switchTab('accounts');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/savings.blade.php ENDPATH**/ ?>