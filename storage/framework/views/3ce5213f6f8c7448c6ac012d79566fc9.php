

<?php $__env->startSection('title', $member->name . ' - Member Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-700 font-bold text-xl">
                        <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                    </span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-900"><?php echo e($member->name); ?></h1>
                    <div class="flex items-center gap-3 mt-2">
                        <p class="text-gray-600"><?php echo e($member->employee_number); ?></p>
                        <span class="text-gray-400">•</span>
                        <p class="text-gray-600"><?php echo e($member->department ?? 'No Department'); ?></p>
                        <span class="text-gray-400">•</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->sacco_status == 'active'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                Active
                            </span>
                        <?php elseif($member->sacco_status == 'inactive'): ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                Inactive
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 border border-red-200">
                                Suspended
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="<?php echo e(route('treasurer.members')); ?>"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    ← Back to Members
                </a>
                <button onclick="window.print()"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    🖨️ Print
                </button>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-500 text-sm">Contact Information</p>
                <p class="font-medium text-gray-900 mt-1"><?php echo e($member->email); ?></p>
                <p class="text-gray-600"><?php echo e($member->phone ?? 'No phone number'); ?></p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-500 text-sm">Membership</p>
                <p class="font-medium text-gray-900 mt-1">Member since <?php echo e($member->created_at->format('d M Y')); ?></p>
                <p class="text-gray-600"><?php echo e($member->created_at->diffForHumans()); ?></p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-500 text-sm">Deduction Settings</p>
                <div class="mt-1 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">KES <?php echo e(number_format($member->monthly_savings ?? 0, 2)); ?></p>
                        <p class="text-gray-600 text-sm">Monthly savings</p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->deduction_active): ?>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                            Active
                        </span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 border border-red-200">
                            Inactive
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Financial Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Total Savings</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">KES <?php echo e(number_format($totalSavings, 2)); ?></p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">💰</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Active Loans</p>
                    <p class="text-2xl font-bold text-purple-600 mt-2">KES <?php echo e(number_format($totalLoans, 2)); ?></p>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($activeLoans->count()); ?> loan(s)</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">🏦</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Paid Loans</p>
                    <p class="text-2xl font-bold text-blue-600 mt-2">KES <?php echo e(number_format($totalPaidLoans, 2)); ?></p>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($member->loans->where('status', 'paid')->count()); ?> loan(s)</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">✅</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Loan Eligibility</p>
                    <p class="text-2xl font-bold text-orange-600 mt-2">KES <?php echo e(number_format($loanEligibility, 2)); ?></p>
                    <p class="text-gray-500 text-xs mt-1">Based on savings × 1.5</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">📈</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('loans')" id="loansTab"
                    class="px-6 py-4 font-medium border-b-2 border-purple-600 text-purple-700 whitespace-nowrap">
                    🏦 Loans History
                </button>
                <button onclick="switchTab('savings')" id="savingsTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    💰 Savings Transactions
                </button>
                <button onclick="switchTab('deductions')" id="deductionsTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📋 Monthly Deductions
                </button>
            </nav>
        </div>
        
        <!-- Loans Tab -->
        <div id="loansContent" class="p-6">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Loan History</h3>
                <p class="text-gray-500 text-sm"><?php echo e($member->loans->count()); ?> total loans</p>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->loans->count() > 0): ?>
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loan #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Purpose</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Taken</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $member->loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900"><?php echo e($loan->loan_number); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900"><?php echo e($loan->purpose); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($loan->period_months); ?> months</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                <p class="text-gray-500 text-xs">KES <?php echo e(number_format($loan->monthly_payment, 2)); ?>/month</p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status == 'active' || $loan->status == 'disbursed'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Active
                                    </span>
                                <?php elseif($loan->status == 'paid'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        Paid
                                    </span>
                                <?php elseif($loan->status == 'pending'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Pending
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        <?php echo e(ucfirst($loan->status)); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium <?php echo e($loan->remaining_balance > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                                    KES <?php echo e(number_format($loan->remaining_balance, 2)); ?>

                                </p>
                                <p class="text-gray-500 text-xs"><?php echo e($loan->percentage_paid ?? 0); ?>% paid</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900 text-sm"><?php echo e($loan->created_at->format('d M Y')); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($loan->created_at->diffForHumans()); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <a href="<?php echo e(route('treasurer.loans.view', $loan->id)); ?>"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-gray-400 text-2xl">🏦</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Loans Found</h3>
                <p class="text-gray-500">This member has not taken any loans yet.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <!-- Savings Tab -->
        <div id="savingsContent" class="p-6 hidden">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Savings Account</h3>
                <p class="text-gray-500 text-sm">Available: KES <?php echo e(number_format($totalSavings, 2)); ?></p>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->savings): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Account Summary</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Deposits</span>
                            <span class="font-medium">KES <?php echo e(number_format($member->savings->total_deposits ?? 0, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Withdrawals</span>
                            <span class="font-medium">KES <?php echo e(number_format($member->savings->total_withdrawn ?? 0, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Created</span>
                            <span class="font-medium"><?php echo e($member->savings->created_at->format('d M Y')); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Updated</span>
                            <span class="font-medium"><?php echo e($member->savings->updated_at->format('d M Y')); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Recent Transactions</h4>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->savingsTransactions->count() > 0): ?>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $member->savingsTransactions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900 text-sm"><?php echo e($transaction->description); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($transaction->transaction_date->format('d M Y')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium <?php echo e($transaction->type == 'deposit' ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($transaction->type == 'deposit' ? '+' : '-'); ?>KES <?php echo e(number_format($transaction->amount, 2)); ?>

                                </p>
                                <p class="text-gray-500 text-xs"><?php echo e(ucfirst($transaction->status)); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php else: ?>
                    <p class="text-gray-500 text-sm">No recent transactions</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-gray-400 text-2xl">💰</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Savings Account</h3>
                <p class="text-gray-500">This member does not have a savings account yet.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <!-- Deductions Tab -->
        <div id="deductionsContent" class="p-6 hidden">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Monthly Deductions History</h3>
                <p class="text-gray-500 text-sm">Current: KES <?php echo e(number_format($member->monthly_savings ?? 0, 2)); ?>/month</p>
            </div>
            
            <?php
                $deductions = \App\Models\MonthlyDeduction::where('user_id', $member->id)
                    ->orderBy('month', 'desc')
                    ->take(12)
                    ->get();
            ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deductions->count() > 0): ?>
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Month</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjusted</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900"><?php echo e(date('F Y', strtotime($deduction->month))); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-green-600 font-medium">KES <?php echo e(number_format($deduction->savings_final, 2)); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->savings_adjustment != 0): ?>
                                    <p class="text-gray-500 text-xs">
                                        <?php echo e($deduction->savings_adjustment > 0 ? '+' : ''); ?><?php echo e(number_format($deduction->savings_adjustment, 2)); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-purple-600 font-medium">KES <?php echo e(number_format($deduction->loan_final, 2)); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->loan_adjustment != 0): ?>
                                    <p class="text-gray-500 text-xs">
                                        <?php echo e($deduction->loan_adjustment > 0 ? '+' : ''); ?><?php echo e(number_format($deduction->loan_adjustment, 2)); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($deduction->total_amount, 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->status == 'committed'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Committed
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Draft
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->is_adjusted): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Yes
                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->adjustment_notes): ?>
                                        <p class="text-gray-500 text-xs mt-1"><?php echo e(Str::limit($deduction->adjustment_notes, 30)); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        No
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-gray-400 text-2xl">📋</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Deduction History</h3>
                <p class="text-gray-500">This member has no monthly deduction records yet.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<script>
// Tab switching - CLEANER VERSION
function switchTab(tabName) {
    // Define tab configurations
    const tabConfigs = {
        'loans': {
            content: 'loansContent',
            button: 'loansTab',
            borderClass: 'border-purple-600',
            textClass: 'text-purple-700'
        },
        'savings': {
            content: 'savingsContent',
            button: 'savingsTab',
            borderClass: 'border-green-600',
            textClass: 'text-green-700'
        },
        'deductions': {
            content: 'deductionsContent',
            button: 'deductionsTab',
            borderClass: 'border-blue-600',
            textClass: 'text-blue-700'
        }
    };

    // Reset all tabs
    Object.values(tabConfigs).forEach(config => {
        const content = document.getElementById(config.content);
        const tabBtn = document.getElementById(config.button);
        
        if (content) {
            content.classList.add('hidden');
        }
        
        if (tabBtn) {
            // Remove all styling classes
            tabBtn.classList.remove(
                'border-b-2',
                'border-purple-600', 'text-purple-700',
                'border-green-600', 'text-green-700',
                'border-blue-600', 'text-blue-700'
            );
            
            // Set to default state
            tabBtn.classList.add('text-gray-500');
        }
    });

    // Activate selected tab
    const selectedConfig = tabConfigs[tabName];
    if (!selectedConfig) return;

    const selectedContent = document.getElementById(selectedConfig.content);
    const selectedTab = document.getElementById(selectedConfig.button);

    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    if (selectedTab) {
        selectedTab.classList.remove('text-gray-500');
        selectedTab.classList.add('border-b-2', selectedConfig.borderClass, selectedConfig.textClass);
    }
}

// Initialize first tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('loans');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/member-detail.blade.php ENDPATH**/ ?>