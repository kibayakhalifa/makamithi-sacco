

<?php $__env->startSection('title', 'Monthly Deduction System'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header with Month Selection and Actions -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">📋</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Monthly Deduction System</h1>
                        <p class="text-gray-500 text-sm md:text-base">Generate, review, and commit monthly payroll deductions</p>
                    </div>
                </div>
                
                <!-- Month Selection -->
                <div class="mt-4 flex items-center gap-3">
                    <select id="monthSelect" onchange="loadMonth()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $monthOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($option['value']); ?>" 
                                    <?php echo e($selectedMonth == $option['value'] ? 'selected' : ''); ?>

                                    data-status="<?php echo e($option['status']); ?>">
                                <?php echo e($option['label']); ?> - <?php echo e(ucfirst($option['status'])); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    
                    <!-- Month Status Badge -->
                    <div id="monthStatus" class="px-3 py-1 rounded-full text-sm font-medium
                        <?php echo e($commitment->status == 'draft' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                           ($commitment->status == 'committed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                           'bg-gray-100 text-gray-800 border border-gray-200')); ?>">
                        <?php echo e(ucfirst($commitment->status)); ?>

                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$deductionsExist && $commitment->canCommit()): ?>
                    <button onclick="generateDeductions()" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>➕</span> Add Deductions for <?php echo e(date('F Y', strtotime($selectedMonth))); ?>

                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deductionsExist && $commitment->canCommit()): ?>
                    <button onclick="regenerateDeductions()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>🔄</span> Regenerate Deductions
                    </button>
                    
                    <button onclick="commitMonth()" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>🔒</span> Commit Month
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deductionsExist && $commitment->isCommitted()): ?>
                    <button onclick="exportDeductions('savings')" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export Savings
                    </button>
                    
                    <button onclick="exportDeductions('loan')" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export Loans
                    </button>
                    
                    <button onclick="exportDeductions('total')" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export All
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        
        <!-- Stats -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deductionsExist): ?>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Members</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($stats['total_members']); ?></p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <span class="text-blue-600 text-xl">👥</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['total_savings'], 2)); ?></p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Loans</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['total_loans'], 2)); ?></p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <span class="text-purple-600 text-xl">🏦</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Grand Total</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($stats['total_amount'], 2)); ?></p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <span class="text-orange-600 text-xl">📊</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <!-- Main Content Tabs -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deductionsExist): ?>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('savings')" id="savingsTab"
                    class="px-6 py-4 font-medium border-b-2 border-green-600 text-green-700 whitespace-nowrap">
                    💰 Savings Summary
                </button>
                <button onclick="switchTab('loans')" id="loansTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    🏦 Loan Summary
                </button>
                <button onclick="switchTab('total')" id="totalTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📊 Total (Combined) Summary
                </button>
                <button onclick="switchTab('monthly')" id="monthlyTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📅 Monthly Summaries
                </button>
            </nav>
        </div>
        
        <!-- Tab 1: Savings Summary -->
        <div id="savingsContent" class="p-6">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Savings Deductions</h3>
                    <p class="text-gray-500 text-sm">Fixed monthly savings amounts with one-off adjustments</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Total: <span class="font-bold text-green-600">KES <?php echo e(number_format($savingsTotal, 2)); ?></span></p>
                    <p class="text-gray-500 text-xs"><?php echo e($savingsSummary->count()); ?> members</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Standard Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjustment</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Final Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $savingsSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-50' : ''); ?>">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-100' : 'bg-green-100'); ?> rounded-full flex items-center justify-center mr-3">
                                        <span class="<?php echo e($deduction['is_adjusted'] ? 'text-yellow-700' : 'text-green-700'); ?> text-sm font-medium">
                                            <?php echo e(strtoupper(substr($deduction['member']->name, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm"><?php echo e($deduction['member']->name); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($deduction['employee_number']); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($deduction['department'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">KES <?php echo e(number_format($deduction['savings_amount'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['savings_adjustment'] != 0): ?>
                                    <p class="font-medium <?php echo e($deduction['savings_adjustment'] > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e($deduction['savings_adjustment'] > 0 ? '+' : ''); ?>KES <?php echo e(number_format($deduction['savings_adjustment'], 2)); ?>

                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['adjustment_notes']): ?>
                                        <p class="text-gray-500 text-xs mt-1"><?php echo e($deduction['adjustment_notes']); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm">No adjustment</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($deduction['savings_final'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['is_adjusted']): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Adjusted
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Standard
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                            <td class="px-4 py-3">
                                <button onclick="editDeduction(<?php echo e($deduction['id']); ?>, 'savings', <?php echo e($deduction['savings_amount']); ?>, <?php echo e($deduction['savings_adjustment']); ?>)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                    Edit
                                </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['is_adjusted']): ?>
                                <button onclick="resetDeduction(<?php echo e($deduction['id']); ?>)"
                                        class="ml-2 bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                    Reset
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab 2: Loan Summary -->
        <div id="loansContent" class="p-6 hidden">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Loan Repayment Deductions</h3>
                    <p class="text-gray-500 text-sm">Active loan repayments with adjustments</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Total: <span class="font-bold text-purple-600">KES <?php echo e(number_format($loanTotal, 2)); ?></span></p>
                    <p class="text-gray-500 text-xs"><?php echo e($loanSummary->count()); ?> members</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Active Loans</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Standard Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjustment</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Final Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loanSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-50' : ''); ?>">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-100' : 'bg-purple-100'); ?> rounded-full flex items-center justify-center mr-3">
                                        <span class="<?php echo e($deduction['is_adjusted'] ? 'text-yellow-700' : 'text-purple-700'); ?> text-sm font-medium">
                                            <?php echo e(strtoupper(substr($deduction['member']->name, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm"><?php echo e($deduction['member']->name); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($deduction['employee_number']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($deduction['active_loans']) > 0): ?>
                                    <div class="space-y-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $deduction['active_loans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="text-xs">
                                            <span class="font-medium">#<?php echo e($loan['loan_number']); ?></span>
                                            <span class="text-gray-500"> - KES <?php echo e(number_format($loan['monthly_payment'], 2)); ?></span>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm">No active loans</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">KES <?php echo e(number_format($deduction['loan_amount'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['loan_adjustment'] != 0): ?>
                                    <p class="font-medium <?php echo e($deduction['loan_adjustment'] > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e($deduction['loan_adjustment'] > 0 ? '+' : ''); ?>KES <?php echo e(number_format($deduction['loan_adjustment'], 2)); ?>

                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['adjustment_notes']): ?>
                                        <p class="text-gray-500 text-xs mt-1"><?php echo e($deduction['adjustment_notes']); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm">No adjustment</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($deduction['loan_final'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['is_adjusted']): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Adjusted
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                        Standard
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                            <td class="px-4 py-3">
                                <button onclick="editDeduction(<?php echo e($deduction['id']); ?>, 'loan', <?php echo e($deduction['loan_amount']); ?>, <?php echo e($deduction['loan_adjustment']); ?>)"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                    Edit
                                </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['is_adjusted']): ?>
                                <button onclick="resetDeduction(<?php echo e($deduction['id']); ?>)"
                                        class="ml-2 bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                    Reset
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab 3: Total Summary -->
        <div id="totalContent" class="p-6 hidden">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Combined Deductions Summary</h3>
                    <p class="text-gray-500 text-sm">Total deductions per member (Savings + Loans)</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Grand Total: <span class="font-bold text-blue-600">KES <?php echo e(number_format($grandTotal, 2)); ?></span></p>
                    <p class="text-gray-500 text-xs"><?php echo e($totalSummary->count()); ?> members</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $totalSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-50' : ''); ?>">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 <?php echo e($deduction['is_adjusted'] ? 'bg-yellow-100' : 'bg-blue-100'); ?> rounded-full flex items-center justify-center mr-3">
                                        <span class="<?php echo e($deduction['is_adjusted'] ? 'text-yellow-700' : 'text-blue-700'); ?> text-sm font-medium">
                                            <?php echo e(strtoupper(substr($deduction['member']->name, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm"><?php echo e($deduction['member']->name); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($deduction['employee_number']); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($deduction['department'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-green-600">KES <?php echo e(number_format($deduction['savings_final'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-purple-600">KES <?php echo e(number_format($deduction['loan_final'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($deduction['total_amount'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['is_adjusted']): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Adjusted
                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['adjustment_notes']): ?>
                                        <p class="text-gray-500 text-xs mt-1"><?php echo e($deduction['adjustment_notes']); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Standard
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tab 4: Monthly Summaries -->
        <div id="monthlyContent" class="p-6 hidden">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Monthly Commitment History</h3>
                <p class="text-gray-500 text-sm">Overview of all months with commitment status</p>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Month</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Members</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjusted</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Committed</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $monthlySummaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="loadSpecificMonth('<?php echo e($summary['month']); ?>')">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900"><?php echo e($summary['label']); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary['status'] == 'draft'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Draft
                                    </span>
                                <?php elseif($summary['status'] == 'committed'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Committed
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        Locked
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900"><?php echo e($summary['member_count']); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-green-600 font-medium">KES <?php echo e(number_format($summary['total_savings'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-purple-600 font-medium">KES <?php echo e(number_format($summary['total_loans'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($summary['total_amount'], 2)); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900"><?php echo e($summary['adjusted_count']); ?></p>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($summary['committed_at']): ?>
                                    <p class="text-gray-900 text-sm"><?php echo e($summary['committed_at']); ?></p>
                                    <p class="text-gray-500 text-xs">by <?php echo e($summary['committed_by'] ?? 'System'); ?></p>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm">Not committed</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-blue-600 text-2xl">📋</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Deductions Generated Yet</h3>
        <p class="text-gray-500 mb-6">Generate deductions for <?php echo e(date('F Y', strtotime($selectedMonth))); ?> to start the review process.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commitment->canCommit()): ?>
        <button onclick="generateDeductions()" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 mx-auto">
            <span>➕</span> Generate Deductions for <?php echo e(date('F Y', strtotime($selectedMonth))); ?>

        </button>
        <?php else: ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-yellow-800 text-sm">This month is already committed or locked. Select a different month to generate deductions.</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<!-- Edit Deduction Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Adjust Deduction</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✕
                </button>
            </div>
        </div>
        
        <form id="editForm" class="p-6">
            <input type="hidden" id="deductionId">
            <input type="hidden" id="deductionType">
            <input type="hidden" id="standardAmount">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Standard Amount</label>
                    <p id="standardAmountDisplay" class="text-lg font-bold text-gray-900"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Amount (KES)</label>
                    <input type="number" id="adjustmentAmount" step="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                           placeholder="Enter adjustment amount (positive or negative)">
                    <p class="text-gray-500 text-xs mt-1">Positive to increase, negative to decrease</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Final Amount</label>
                    <p id="finalAmountDisplay" class="text-lg font-bold text-green-600"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Notes</label>
                    <textarea id="adjustmentNotes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Reason for adjustment..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    Save Adjustment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Commit Month Modal -->
<div id="commitModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Commit Month</h3>
                <button onclick="closeCommitModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✕
                </button>
            </div>
        </div>
        
        <form id="commitForm" class="p-6">
            <div class="space-y-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="text-yellow-600 mr-2">⚠️</span>
                        <p class="text-yellow-800 text-sm font-medium">Important: This action cannot be undone</p>
                    </div>
                    <p class="text-yellow-600 text-xs mt-2">
                        Once committed, all deductions for <?php echo e(date('F Y', strtotime($selectedMonth))); ?> will be locked and cannot be edited.
                    </p>
                </div>
                
                <div>
                    <p class="text-gray-700 text-sm mb-2">You are about to commit:</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• <?php echo e($stats['total_members'] ?? 0); ?> members</li>
                        <li>• KES <?php echo e(number_format($stats['total_savings'] ?? 0, 2)); ?> in savings deductions</li>
                        <li>• KES <?php echo e(number_format($stats['total_loans'] ?? 0, 2)); ?> in loan repayments</li>
                        <li>• KES <?php echo e(number_format($stats['total_amount'] ?? 0, 2)); ?> total amount</li>
                    </ul>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commitment Notes (Optional)</label>
                    <textarea id="commitmentNotes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Add any notes about this commitment..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeCommitModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium">
                    Confirm & Commit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching - FIXED
function switchTab(tabName) {
    // Hide all content
    ['savings', 'loans', 'total', 'monthly'].forEach(tab => {
        const content = document.getElementById(tab + 'Content');
        const tabBtn = document.getElementById(tab + 'Tab');
        
        if (content) {
            content.classList.add('hidden');
        }
        
        if (tabBtn) {
            // Remove specific border and text classes
            tabBtn.classList.remove(
                'border-b-2', 
                'border-green-600', 
                'text-green-700',
                'border-purple-600', 
                'text-purple-700',
                'border-blue-600', 
                'text-blue-700',
                'border-gray-600', 
                'text-gray-700'
            );
            
            // Add default styling
            tabBtn.classList.add('text-gray-500');
        }
    });

    // Show selected content
    const selectedContent = document.getElementById(tabName + 'Content');
    const selectedTab = document.getElementById(tabName + 'Tab');

    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    if (selectedTab) {
        // Remove default styling
        selectedTab.classList.remove('text-gray-500');
        
        // Add active styling based on tab
        const borderClass = tabName === 'savings' ? 'border-green-600' :
                           tabName === 'loans' ? 'border-purple-600' :
                           tabName === 'total' ? 'border-blue-600' :
                           'border-gray-600';
        
        const textClass = tabName === 'savings' ? 'text-green-700' :
                         tabName === 'loans' ? 'text-purple-700' :
                         tabName === 'total' ? 'text-blue-700' :
                         'text-gray-700';
        
        selectedTab.classList.add('border-b-2', borderClass, textClass);
    }
}

// Load specific month
function loadMonth() {
    const monthSelect = document.getElementById('monthSelect');
    const month = monthSelect.value;
    window.location.href = '/treasurer/savings-deductions?month=' + month;
}

function loadSpecificMonth(month) {
    window.location.href = '/treasurer/savings-deductions?month=' + month;
}

// Generate deductions
async function generateDeductions() {
    const month = document.getElementById('monthSelect').value;
    
    if (!confirm(`Generate deductions for ${month}? This will create draft deductions for all active members.`)) {
        return;
    }
    
    try {
        const response = await fetch('/treasurer/generate-deductions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ month: month })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(`✅ ${data.message}`);
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error generating deductions');
        console.error(error);
    }
}

// Regenerate deductions
async function regenerateDeductions() {
    const month = document.getElementById('monthSelect').value;
    
    if (!confirm(`Regenerate deductions for ${month}? This will overwrite existing draft deductions.`)) {
        return;
    }
    
    try {
        const response = await fetch('/treasurer/regenerate-deductions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ month: month })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(`✅ ${data.message}`);
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error regenerating deductions');
        console.error(error);
    }
}

// Edit deduction modal
function editDeduction(id, type, standardAmount, currentAdjustment) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const deductionId = document.getElementById('deductionId');
    const deductionType = document.getElementById('deductionType');
    const standardAmountInput = document.getElementById('standardAmount');
    const standardAmountDisplay = document.getElementById('standardAmountDisplay');
    const adjustmentAmount = document.getElementById('adjustmentAmount');
    const finalAmountDisplay = document.getElementById('finalAmountDisplay');
    const adjustmentNotes = document.getElementById('adjustmentNotes');
    
    deductionId.value = id;
    deductionType.value = type;
    standardAmountInput.value = standardAmount;
    standardAmountDisplay.textContent = 'KES ' + standardAmount.toLocaleString('en-US', { minimumFractionDigits: 2 });
    adjustmentAmount.value = currentAdjustment || 0;
    adjustmentNotes.value = '';
    
    // Calculate initial final amount
    updateFinalAmountDisplay();
    
    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function updateFinalAmountDisplay() {
    const standardAmount = parseFloat(document.getElementById('standardAmount').value);
    const adjustment = parseFloat(document.getElementById('adjustmentAmount').value) || 0;
    const finalAmount = standardAmount + adjustment;
    
    document.getElementById('finalAmountDisplay').textContent = 
        'KES ' + finalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 });
}

// Close edit modal
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    // Reset form
    document.getElementById('editForm').reset();
    document.getElementById('adjustmentNotes').value = '';
}

// Save deduction adjustment
document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const deductionId = document.getElementById('deductionId').value;
    const type = document.getElementById('deductionType').value;
    const adjustment = parseFloat(document.getElementById('adjustmentAmount').value) || 0;
    const notes = document.getElementById('adjustmentNotes').value;
    
    try {
        const response = await fetch(`/treasurer/deductions/${deductionId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                type: type,
                adjustment: adjustment,
                notes: notes
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Deduction updated successfully');
            closeEditModal();
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error updating deduction');
        console.error(error);
    }
});

// Reset deduction
async function resetDeduction(id) {
    if (!confirm('Reset this deduction to its original values?')) {
        return;
    }
    
    try {
        const response = await fetch(`/treasurer/deductions/${id}/reset`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Deduction reset successfully');
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error resetting deduction');
        console.error(error);
    }
}

// Commit month modal
function commitMonth() {
    const modal = document.getElementById('commitModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCommitModal() {
    const modal = document.getElementById('commitModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Save commitment
document.getElementById('commitForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const month = document.getElementById('monthSelect').value;
    const notes = document.getElementById('commitmentNotes').value;
    
    try {
        const response = await fetch('/treasurer/commit-month', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                month: month,
                notes: notes
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Month committed successfully');
            closeCommitModal();
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error committing month');
        console.error(error);
    }
});

// Export deductions
function exportDeductions(type) {
    const month = document.getElementById('monthSelect').value;
    window.location.href = `/treasurer/export-month-deductions?month=${month}&type=${type}`;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set up adjustment amount listener
    const adjustmentAmount = document.getElementById('adjustmentAmount');
    if (adjustmentAmount) {
        adjustmentAmount.addEventListener('input', updateFinalAmountDisplay);
        adjustmentAmount.addEventListener('change', updateFinalAmountDisplay);
    }
    
    // Initialize first tab
    switchTab('savings');
    
    // Add month select change listener
    const monthSelect = document.getElementById('monthSelect');
    if (monthSelect) {
        monthSelect.addEventListener('change', loadMonth);
    }
    
    // Add click handlers for tab buttons
    document.querySelectorAll('nav button[id$="Tab"]').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.id.replace('Tab', '');
            switchTab(tabName);
        });
    });
    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const editModal = document.getElementById('editModal');
        const commitModal = document.getElementById('commitModal');
        
        if (editModal && !editModal.classList.contains('hidden')) {
            if (event.target === editModal) {
                closeEditModal();
            }
        }
        
        if (commitModal && !commitModal.classList.contains('hidden')) {
            if (event.target === commitModal) {
                closeCommitModal();
            }
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const editModal = document.getElementById('editModal');
            const commitModal = document.getElementById('commitModal');
            
            if (editModal && !editModal.classList.contains('hidden')) {
                closeEditModal();
            }
            
            if (commitModal && !commitModal.classList.contains('hidden')) {
                closeCommitModal();
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/savings-with-deductions.blade.php ENDPATH**/ ?>