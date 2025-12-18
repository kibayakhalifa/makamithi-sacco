<?php $__env->startSection('title', 'Payment Processing'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <span class="text-orange-700 font-bold">💳</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Payment Processing</h1>
                        <p class="text-gray-500 text-sm md:text-base">Process loan disbursements, savings withdrawals, and expenses</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Pending Payments</p>
                    <p class="text-3xl font-bold text-gray-900">KES <?php echo e(number_format($paymentStats['total_pending'], 2)); ?></p>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($paymentStats['pending_count']); ?> payments to process</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Loan Disbursements</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingDisbursements->count()); ?></p>
                    <p class="text-gray-500 text-sm mt-1">KES <?php echo e(number_format($pendingDisbursements->sum('amount'), 2)); ?></p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">🏦</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Withdrawals</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingWithdrawals->count()); ?></p>
                    <p class="text-gray-500 text-sm mt-1">KES <?php echo e(number_format($pendingWithdrawals->sum('amount'), 2)); ?></p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">💰</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Expenses</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pendingExpenses->count()); ?></p>
                    <p class="text-gray-500 text-sm mt-1">KES <?php echo e(number_format($pendingExpenses->sum('amount'), 2)); ?></p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">💸</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Today's Processed</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($paymentStats['today_completed'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Completed payments</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
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
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Approval Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingDisbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($loan->loan_number); ?></p>
                                        <p class="text-gray-500 text-xs">5% interest • <?php echo e($loan->period_months); ?> months</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($loan->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($loan->user->name); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($loan->user->employee_number); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p><?php echo e($loan->approved_date?->format('d M Y')); ?></p>
                                            <p class="text-gray-500 text-xs">By <?php echo e($loan->approvedBy->name ?? 'Committee'); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <form method="POST" action="<?php echo e(route('treasurer.loans.disburse', $loan->id)); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="payment_method" value="cash">
                                                <input type="hidden" name="reference_number" value="DISB-<?php echo e(date('YmdHis')); ?>">
                                                <input type="hidden" name="notes" value="Loan disbursement">
                                                <button type="submit"
                                                    onclick="return confirm('Disburse loan <?php echo e($loan->loan_number); ?> for KES <?php echo e(number_format($loan->amount, 2)); ?>?')"
                                                    class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                    Disburse
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
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
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Disbursements</h3>
                    <p class="text-gray-500">All approved loans have been disbursed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Withdrawals -->
        <div id="withdrawalsContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingWithdrawals->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Withdrawal Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Request Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingWithdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($withdrawal->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($withdrawal->transaction_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($withdrawal->description); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($withdrawal->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($withdrawal->user->name); ?></p>
                                                <p class="text-gray-500 text-xs">Savings: KES <?php echo e(number_format($withdrawal->user->savings->available_savings ?? 0, 2)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <?php echo e($withdrawal->created_at->format('d M Y')); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="processWithdrawal(<?php echo e($withdrawal->id); ?>)"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Process
                                            </button>
                                            <button onclick="rejectWithdrawal(<?php echo e($withdrawal->id); ?>)"
                                                class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1.5 rounded text-xs font-medium">
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
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Withdrawals</h3>
                    <p class="text-gray-500">All withdrawal requests have been processed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Expenses -->
        <div id="expensesContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingExpenses->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Expense Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Requested By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($expense->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($expense->expense_number); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($expense->description); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($expense->category->color_class ?? 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo e($expense->category->name ?? 'Uncategorized'); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($expense->requestedBy->name ?? 'N/A'); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($expense->created_at->format('d M Y')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="payExpense(<?php echo e($expense->id); ?>)"
                                                class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Pay
                                            </button>
                                            <a href="<?php echo e(route('expenses.show', $expense->id)); ?>"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
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
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">💸</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Expenses</h3>
                    <p class="text-gray-500">All approved expenses have been paid.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Completed Payments -->
        <div id="completedContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentPayments->count() > 0): ?>
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Payment Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member/Beneficiary</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($payment->amount, 2)); ?></p>
                                        <p class="text-gray-500 text-sm">#<?php echo e($payment->payment_ref); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($payment->payment_method); ?></p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->loan_id): ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full border border-blue-200">Loan</span>
                                        <?php elseif($payment->savings_transaction_id): ?>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200">Withdrawal</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full border border-orange-200">Expense</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->loan && $payment->loan->user): ?>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($payment->loan->user->name); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($payment->loan->user->employee_number); ?></p>
                                        <?php elseif($payment->savingsTransaction && $payment->savingsTransaction->user): ?>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($payment->savingsTransaction->user->name); ?></p>
                                            <p class="text-gray-500 text-xs">Savings Withdrawal</p>
                                        <?php else: ?>
                                            <p class="text-gray-500 text-sm">N/A</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p><?php echo e($payment->payment_date->format('d M Y')); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($payment->payment_date->format('h:i A')); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200">Completed</span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Recent Payments</h3>
                    <p class="text-gray-500">Payment history will appear here.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Reports</h3>
            <div class="space-y-3">
                <button onclick="generatePaymentReport('daily')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📊 Daily Payment Summary</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generatePaymentReport('monthly')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📈 Monthly Payment Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportPaymentHistory()"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>💾 Export Payment History</span>
                    <span class="text-gray-400">→</span>
                </button>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Actions</h3>
            <div class="space-y-3">
                <button onclick="processAllCheques()"
                    class="w-full text-left px-4 py-3 bg-orange-50 hover:bg-orange-100 rounded-lg text-sm flex justify-between items-center border border-orange-200">
                    <span class="text-orange-800">🏦 Process All Disbursements</span>
                    <span class="text-orange-600">→</span>
                </button>
                <button onclick="uploadPayroll()"
                    class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 rounded-lg text-sm flex justify-between items-center border border-green-200">
                    <span class="text-green-800">📤 Upload Payroll Deductions</span>
                    <span class="text-green-600">→</span>
                </button>
                <button onclick="processAllWithdrawals()"
                    class="w-full text-left px-4 py-3 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm flex justify-between items-center border border-blue-200">
                    <span class="text-blue-800">💰 Process All Withdrawals</span>
                    <span class="text-blue-600">→</span>
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
        if (confirm(`Issue cheques for all <?php echo e($pendingDisbursements->count()); ?> pending loans?`)) {
            // Bulk processing logic
            alert('Processing all cheques...');
            // AJAX call here
        }
    }

    function processAllWithdrawals() {
        const count = <?php echo e($pendingWithdrawals->count()); ?>;
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
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('disbursements');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/payments.blade.php ENDPATH**/ ?>