

<?php $__env->startSection('title', 'Payment Processing'); ?>

<?php $__env->startPush('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 font-sans">

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-700 font-bold text-lg">1</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Payment Processing</h1>
                    </div>
                    <p class="text-green-800">Process loan disbursements, savings withdrawals, and expenses</p>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                        <p class="text-green-600 text-sm font-medium">Pending Payments</p>
                        <p class="text-4xl font-bold text-gray-900">KES
                            <?php echo e(number_format($paymentStats['total_pending'], 2)); ?>

                        </p>
                        <p class="text-gray-500 text-xs mt-1"><?php echo e($paymentStats['pending_count']); ?> payments to process</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Loan Disbursements</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingDisbursements->count()); ?></p>
                        <p class="text-gray-500 text-sm mt-1">KES
                            <?php echo e(number_format($pendingDisbursements->sum('amount'), 2)); ?>

                        </p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">🏦</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Withdrawals</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingWithdrawals->count()); ?></p>
                        <p class="text-gray-500 text-sm mt-1">KES <?php echo e(number_format($pendingWithdrawals->sum('amount'), 2)); ?>

                        </p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Expenses</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingExpenses->count()); ?></p>
                        <p class="text-gray-500 text-sm mt-1">KES <?php echo e(number_format($pendingExpenses->sum('amount'), 2)); ?>

                        </p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">💸</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Today's Processed</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($paymentStats['today_completed'], 2)); ?>

                        </p>
                        <p class="text-gray-500 text-sm mt-1">Completed payments</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">✅</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto">
                    <button onclick="switchTab('disbursements')" id="disbursementsTab"
                        class="px-6 py-4 font-medium border-b-2 border-orange-600 text-orange-700 whitespace-nowrap">
                        🏦 Loan Disbursements (<?php echo e($pendingDisbursements->count()); ?>)
                    </button>
                    <button onclick="switchTab('withdrawals')" id="withdrawalsTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        💰 Savings Withdrawals (<?php echo e($pendingWithdrawals->count()); ?>)
                    </button>
                    <button onclick="switchTab('expenses')" id="expensesTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        💸 Expenses (<?php echo e($pendingExpenses->count()); ?>)
                    </button>
                    <button onclick="switchTab('completed')" id="completedTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        ✅ Completed (<?php echo e($recentPayments->count()); ?>)
                    </button>
                </nav>
            </div>

            <!-- Loan Disbursements -->
            <div id="disbursementsContent" class="p-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingDisbursements->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Loan
                                            Details</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                            Member</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                            Approval Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingDisbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="hover:bg-gray-50 border-b">
                                                        <td class="px-4 py-4">
                                                            <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                                            <p class="text-gray-500 text-sm">#<?php echo e($loan->loan_number); ?></p>
                                                            <p class="text-gray-500 text-xs">5% interest • <?php echo e($loan->period_months); ?> months</p>
                                                        </td>
                                                        <td class="px-4 py-4">
                                                            <div class="flex items-center">
                                                                <div
                                                                    class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                                    <span class="text-gray-700 font-medium">
                                                                        <?php echo e(strtoupper(substr($loan->user->name, 0, 1))); ?>

                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <p class="font-medium text-gray-900"><?php echo e($loan->user->name); ?></p>
                                                                    <p class="text-gray-500 text-sm"><?php echo e($loan->user->employee_number); ?></p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-4">
                                                            <p class="text-gray-900"><?php echo e($loan->approved_date?->format('d M Y')); ?></p>
                                                            <p class="text-gray-500 text-xs">By <?php echo e($loan->approvedBy->name ?? 'Committee'); ?></p>
                                                        </td>
                                                        <td class="px-4 py-4">
                                                            <div class="flex gap-2">
                                                        <td class="px-4 py-4">
                                                            <div class="flex gap-2">
                                                                <!-- Simple form that always works -->
                                                                <form method="POST" action="<?php echo e(route('treasurer.loans.disburse', $loan->id)); ?>"
                                                                    style="display: inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="payment_method" value="cash">
                                                                    <input type="hidden" name="reference_number" value="DISB-<?php echo e(date('YmdHis')); ?>">
                                                                    <input type="hidden" name="notes" value="Loan disbursement">
                                                                    <button type="submit"
                                                                        onclick="return confirm('Disburse loan <?php echo e($loan->loan_number); ?> for KES <?php echo e(number_format($loan->amount, 2)); ?>?')"
                                                                        class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                                        Disburse
                                                                    </button>
                                                                </form>

                                                                <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                                                    View
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
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
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Disbursements</h3>
                    <p class="text-gray-500">All approved loans have been disbursed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Withdrawals -->
        <div id="withdrawalsContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingWithdrawals->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Withdrawal Details</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Member</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Request Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingWithdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($withdrawal->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($withdrawal->transaction_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($withdrawal->description); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 font-medium">
                                                    <?php echo e(strtoupper(substr($withdrawal->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($withdrawal->user->name); ?></p>
                                                <p class="text-gray-500 text-sm">Savings: KES
                                                    <?php echo e(number_format($withdrawal->user->savings->available_savings ?? 0, 2)); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-gray-900"><?php echo e($withdrawal->created_at->format('d M Y')); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex gap-2">
                                            <button onclick="processWithdrawal(<?php echo e($withdrawal->id); ?>)"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                Process
                                            </button>
                                            <button onclick="rejectWithdrawal(<?php echo e($withdrawal->id); ?>)"
                                                class="bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2 rounded-lg text-sm font-medium">
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Withdrawals</h3>
                    <p class="text-gray-500">All withdrawal requests have been processed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Expenses -->
        <div id="expensesContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingExpenses->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Expense Details</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Category</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Requested By</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($expense->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($expense->expense_number); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($expense->description); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                                                                                <?php echo e($expense->category->color_class ?? 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo e($expense->category->name ?? 'Uncategorized'); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="font-medium text-gray-900"><?php echo e($expense->requestedBy->name ?? 'N/A'); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($expense->created_at->format('d M Y')); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex gap-2">
                                            <button onclick="payExpense(<?php echo e($expense->id); ?>)"
                                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                Pay
                                            </button>
                                            <a href="<?php echo e(route('expenses.show', $expense->id)); ?>"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
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
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">💸</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Expenses</h3>
                    <p class="text-gray-500">All approved expenses have been paid.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Completed Payments -->
        <div id="completedContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentPayments->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Payment Details</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Type
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Member/Beneficiary</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($payment->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($payment->payment_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($payment->payment_method); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->loan_id): ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Loan</span>
                                        <?php elseif($payment->savings_transaction_id): ?>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Withdrawal</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">Expense</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->loan && $payment->loan->user): ?>
                                            <p class="font-medium text-gray-900"><?php echo e($payment->loan->user->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($payment->loan->user->employee_number); ?></p>
                                        <?php elseif($payment->savingsTransaction && $payment->savingsTransaction->user): ?>
                                            <p class="font-medium text-gray-900"><?php echo e($payment->savingsTransaction->user->name); ?></p>
                                            <p class="text-gray-500 text-xs">Savings Withdrawal</p>
                                        <?php else: ?>
                                            <p class="text-gray-500 text-sm">N/A</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-gray-900"><?php echo e($payment->payment_date->format('d M Y')); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($payment->payment_date->format('h:i A')); ?></p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completed</span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Recent Payments</h3>
                    <p class="text-gray-500">Payment history will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Reports</h3>
            <div class="space-y-3">
                <button onclick="generatePaymentReport('daily')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📊 Daily Payment Summary</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generatePaymentReport('monthly')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📈 Monthly Payment Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportPaymentHistory()"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>💾 Export Payment History</span>
                    <span class="text-gray-400">→</span>
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
            document.getElementById('disbursementsContent').classList.add('hidden');
            document.getElementById('withdrawalsContent').classList.add('hidden');
            document.getElementById('expensesContent').classList.add('hidden');
            document.getElementById('completedContent').classList.add('hidden');

            // Remove active from all tabs
            document.getElementById('disbursementsTab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
            document.getElementById('disbursementsTab').classList.add('text-gray-500');
            document.getElementById('withdrawalsTab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
            document.getElementById('withdrawalsTab').classList.add('text-gray-500');
            document.getElementById('expensesTab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
            document.getElementById('expensesTab').classList.add('text-gray-500');
            document.getElementById('completedTab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
            document.getElementById('completedTab').classList.add('text-gray-500');

            // Show selected content
            document.getElementById(tabName + 'Content').classList.remove('hidden');

            // Activate selected tab
            document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-orange-600', 'text-orange-700');
            document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
        }

        // Payment processing functions
        function processLoan(loanId, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            console.log('🔍 Starting disbursement for loan:', loanId);

            // Get CSRF token from the INPUT field (not meta tag)
            // From your console: there are inputs with name="_token"
            const csrfInput = document.querySelector('input[name="_token"]');
            let csrfToken = csrfInput ? csrfInput.value : null;

            if (!csrfToken) {
                console.error('❌ No CSRF token found in input fields!');
                alert('Error: CSRF token not found. Please refresh the page.');
                return false;
            }

            console.log('✓ CSRF Token found:', csrfToken.substring(0, 10) + '...');

            if (!confirm(`Disburse loan #${loanId}?`)) {
                console.log('User cancelled');
                return false;
            }

            // Disable button
            const button = event ? event.target : null;
            if (button) {
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = '⏳ Processing...';
            }

            // IMPORTANT: Use the EXACT same format as Laravel expects
            // Laravel expects _token parameter, not in headers for FormData
            const formData = new FormData();
            formData.append('_token', csrfToken);  // Must be '_token' (with underscore)
            formData.append('payment_method', 'cheque');
            formData.append('reference_number', 'DISB-' + Date.now());
            formData.append('notes', 'Loan disbursement');

            const url = `/treasurer/loans/${loanId}/disburse`;
            console.log('📤 POST to:', url);
            console.log('FormData entries:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                // Don't set Content-Type header for FormData - browser does it automatically
            })
                .then(response => {
                    console.log('📥 Response status:', response.status, response.statusText);
                    console.log('Response headers:', Object.fromEntries(response.headers.entries()));

                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    }

                    if (response.redirected) {
                        console.log('🔄 Redirect detected to:', response.url);
                        return { redirected: true, location: response.url };
                    }

                    return response.json()
                        .then(data => {
                            console.log('✅ JSON response:', data);
                            return { data: data };
                        })
                        .catch(async () => {
                            const text = await response.text();
                            console.log('📄 Text response:', text.substring(0, 500));
                            return { text: text };
                        });
                })
                .then(result => {
                    console.log('✅ Request completed:', result);

                    if (result.redirected) {
                        window.location.href = result.location;
                    } else if (result.data) {
                        if (result.data.success) {
                            alert('🎉 ' + (result.data.message || 'Loan disbursed successfully!'));
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            alert('❌ ' + (result.data.error || 'Unknown error'));
                            if (button) button.disabled = false;
                        }
                    } else {
                        console.log('Unexpected response:', result);
                        alert('⚠️ Unexpected response format');
                        if (button) button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('💥 Error:', error);
                    alert('💥 Error: ' + error.message);
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = 'Retry';
                    }
                });

            return false;
        }

        function processWithdrawal(transactionId) {
            if (confirm('Process this savings withdrawal?')) {
                // AJAX call to process withdrawal
                fetch(`/treasurer/withdrawals/${transactionId}/process`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Withdrawal processed successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }

        function rejectWithdrawal(transactionId) {
            const reason = prompt('Reason for rejection:');
            if (reason) {
                // AJAX call to reject withdrawal
                fetch(`/treasurer/withdrawals/${transactionId}/reject`, {
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

        function payExpense(expenseId) {
            // Show payment modal
            const amount = prompt('Enter payment amount:');
            if (amount && !isNaN(amount)) {
                fetch(`/treasurer/expenses/${expenseId}/pay`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ amount: parseFloat(amount) })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Expense paid successfully!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }

        // Bulk processing
        function processAllCheques() {
            if (confirm(`Issue cheques for all ${document.querySelectorAll('#disbursementsContent tr').length - 1} pending loans?`)) {
                // Bulk processing logic
                alert('Processing all cheques...');
                // AJAX call here
            }
        }

        function processAllWithdrawals() {
            const count = document.querySelectorAll('#withdrawalsContent tr').length - 1;
            if (count > 0 && confirm(`Process all ${count} withdrawal requests?`)) {
                alert('Processing all withdrawals...');
                // AJAX call here
            }
        }

        function uploadPayroll() {
            window.location.href = '/treasurer/payroll/upload';
        }

        // Reports
        function generatePaymentReport(type) {
            window.location.href = `/treasurer/reports/payments/${type}`;
        }

        function exportPaymentHistory() {
            if (confirm('Export payment history to Excel?')) {
                window.location.href = '/treasurer/payments/export';
            }
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function () {
            switchTab('disbursements');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/payments.blade.php ENDPATH**/ ?>