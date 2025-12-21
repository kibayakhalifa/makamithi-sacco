

<?php $__env->startSection('title', 'Savings & Payroll Deductions Summary'); ?>

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
                            <p class="text-gray-500 text-sm md:text-base">Manage member savings accounts, withdrawals, and
                                payroll deductions</p>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                        <p class="text-gray-600 text-sm font-medium">Total Member Savings</p>
                        <p class="text-3xl font-bold text-gray-900">KES
                            <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-xs mt-1"><?php echo e($savingsStats['total_members']); ?> members</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Real Data Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Savings -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['total_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1">
                            From <?php echo e($savingsStats['active_members']); ?> active members
                        </p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>

            <!-- Average Savings -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Avg. Savings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['average_savings'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1">
                            Per active member
                        </p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <span class="text-blue-600 text-xl">📊</span>
                    </div>
                </div>
            </div>

            <!-- Pending Withdrawals -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Withdrawals</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($savingsStats['pending_withdrawals']); ?></p>
                        <p class="text-gray-500 text-sm mt-1">
                            KES <?php echo e(number_format($savingsStats['pending_withdrawals_amount'], 2)); ?> pending
                        </p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <span class="text-orange-600 text-xl">⏳</span>
                    </div>
                </div>
            </div>

            <!-- Monthly Deductions -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Monthly Deductions</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES
                            <?php echo e(number_format($savingsStats['monthly_deductions'], 2)); ?></p>
                        <p class="text-gray-500 text-sm mt-1">
                            <?php echo e(number_format($savingsStats['avg_deduction_rate'], 1)); ?>% of salary
                        </p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <span class="text-purple-600 text-xl">📄</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAYROLL DEDUCTION MANAGEMENT SECTION -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto">
                    <button onclick="switchTab('payrollAll')" id="payrollAllTab"
                        class="px-6 py-4 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap">
                        📊 All Members Deductions
                    </button>
                    <button onclick="switchTab('payrollMonthly')" id="payrollMonthlyTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        📅 Monthly Summary
                    </button>
                    <button onclick="switchTab('payrollSavings')" id="payrollSavingsTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        💰 Savings Deductions
                    </button>
                    <button onclick="switchTab('payrollLoans')" id="payrollLoansTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        🏦 Loan Deductions
                    </button>
                    <button onclick="switchTab('payrollSettings')" id="payrollSettingsTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        ⚙️ Deduction Settings
                    </button>
                </nav>
            </div>

            <!-- All Members Deductions Tab -->
            <div id="payrollAllContent" class="p-6">
                <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Payroll Deductions Overview</h3>
                        <p class="text-gray-500 text-sm">Manage and monitor all payroll deductions for savings and loans</p>
                    </div>
                    <div class="flex gap-3">
                        <select id="payrollMonthFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="all">All Months</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $payrollMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($month['value']); ?>"><?php echo e($month['label']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <button onclick="generatePayrollReport()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Generate Payroll File
                        </button>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-blue-800 text-xs font-medium uppercase">Total Deductions</p>
                                <p class="text-2xl font-bold text-blue-900 mt-2">KES
                                    <?php echo e(number_format($payrollSummary['total_deductions'], 2)); ?></p>
                            </div>
                            <span class="text-blue-600 text-2xl">📊</span>
                        </div>
                        <p class="text-blue-700 text-xs mt-2"><?php echo e($payrollSummary['total_members']); ?> members</p>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-green-800 text-xs font-medium uppercase">Savings Deductions</p>
                                <p class="text-2xl font-bold text-green-900 mt-2">KES
                                    <?php echo e(number_format($payrollSummary['savings_deductions'], 2)); ?></p>
                            </div>
                            <span class="text-green-600 text-2xl">💰</span>
                        </div>
                        <p class="text-green-700 text-xs mt-2"><?php echo e($payrollSummary['savings_members']); ?> members</p>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-purple-800 text-xs font-medium uppercase">Loan Repayments</p>
                                <p class="text-2xl font-bold text-purple-900 mt-2">KES
                                    <?php echo e(number_format($payrollSummary['loan_deductions'], 2)); ?></p>
                            </div>
                            <span class="text-purple-600 text-2xl">🏦</span>
                        </div>
                        <p class="text-purple-700 text-xs mt-2"><?php echo e($payrollSummary['loan_members']); ?> members</p>
                    </div>
                </div>

                <!-- Deductions Table -->
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    #</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Member Details</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Monthly Deductions</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Savings</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Loan Repayment</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $payrollDeductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td
                                                        class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                                        <?php echo e($index + 1); ?>

                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <div class="flex items-center">
                                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                                <span class="text-gray-700 text-sm font-medium">
                                                                    <?php echo e(strtoupper(substr($deduction['member']->name, 0, 1))); ?>

                                                                </span>
                                                            </div>
                                                            <div>
                                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($deduction['member']->name); ?>

                                                                </p>
                                                                <p class="text-gray-500 text-xs"><?php echo e($deduction['member']->employee_number); ?></p>
                                                                <p class="text-gray-500 text-xs">Dept:
                                                                    <?php echo e($deduction['member']->department ?? 'N/A'); ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <p class="font-bold text-gray-900 text-sm">KES
                                                            <?php echo e(number_format($deduction['total_monthly_deduction'], 2)); ?></p>
                                                        <p class="text-gray-500 text-xs">Monthly total</p>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['savings_deduction'] > 0): ?>
                                                            <p class="text-green-600 font-medium text-sm">KES
                                                                <?php echo e(number_format($deduction['savings_deduction'], 2)); ?></p>
                                                            <p class="text-gray-500 text-xs">Rate: <?php echo e($deduction['savings_rate']); ?>%</p>
                                                        <?php else: ?>
                                                            <p class="text-gray-400 text-sm">No savings</p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction['loan_deduction'] > 0): ?>
                                                            <p class="text-purple-600 font-medium text-sm">KES
                                                                <?php echo e(number_format($deduction['loan_deduction'], 2)); ?></p>
                                                            <p class="text-gray-500 text-xs">
                                                                <?php echo e($deduction['active_loans']); ?> loan(s)
                                                            </p>
                                                        <?php else: ?>
                                                            <p class="text-gray-400 text-sm">No loans</p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <span class="px-2 py-1 text-xs rounded-full font-medium border 
                                                            <?php echo e($deduction['status'] === 'active' ? 'bg-green-100 text-green-800 border-green-200' :
                                ($deduction['status'] === 'pending' ? 'bg-orange-100 text-orange-800 border-orange-200' :
                                    'bg-red-100 text-red-800 border-red-200')); ?>">
                                                            <?php echo e(ucfirst($deduction['status'])); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                                        <div class="flex gap-2">
                                                            <button onclick="viewMemberDeductions(<?php echo e($deduction['member']->id); ?>)"
                                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                                View
                                                            </button>
                                                            <button onclick="editDeductions(<?php echo e($deduction['member']->id); ?>)"
                                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Monthly Summary Tab -->
            <div id="payrollMonthlyContent" class="p-6 hidden">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Monthly Payroll Deduction Summary</h3>
                    <div class="flex gap-4">
                        <select id="monthSelect" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $monthlySummaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($month['month']); ?>" <?php echo e($month['is_current'] ? 'selected' : ''); ?>>
                                    <?php echo e($month['label']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <button onclick="loadMonthSummary()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Load Summary
                        </button>
                    </div>
                </div>

                <!-- Current Month Summary -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($currentMonthSummary)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Deduction Breakdown</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Total Deductions:</span>
                                    <span class="font-bold text-gray-900">KES
                                        <?php echo e(number_format($currentMonthSummary['total_deductions'], 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Savings Portion:</span>
                                    <span class="font-medium text-green-600">KES
                                        <?php echo e(number_format($currentMonthSummary['savings_amount'], 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 text-sm">Loan Portion:</span>
                                    <span class="font-medium text-purple-600">KES
                                        <?php echo e(number_format($currentMonthSummary['loan_amount'], 2)); ?></span>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 text-sm">Members with deductions:</span>
                                        <span
                                            class="font-medium text-gray-900"><?php echo e($currentMonthSummary['members_count']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Processing Status</h4>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Processed:</span>
                                        <span class="font-medium text-gray-900"><?php echo e($currentMonthSummary['processed_count']); ?> /
                                            <?php echo e($currentMonthSummary['members_count']); ?></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full"
                                            style="width: <?php echo e(($currentMonthSummary['processed_count'] / max($currentMonthSummary['members_count'], 1)) * 100); ?>%">
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div>
                                        <p class="text-yellow-800 text-sm font-medium">Pending Approval</p>
                                        <p class="text-yellow-600 text-xs"><?php echo e($currentMonthSummary['pending_count']); ?> members
                                        </p>
                                    </div>
                                    <button onclick="approveAllDeductions()"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Approve All
                                    </button>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div>
                                        <p class="text-green-800 text-sm font-medium">Ready for Payroll</p>
                                        <p class="text-green-600 text-xs">KES
                                            <?php echo e(number_format($currentMonthSummary['ready_amount'], 2)); ?></p>
                                    </div>
                                    <button onclick="exportPayrollFile()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Export CSV
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Monthly Deduction Chart -->
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Monthly Deduction Trend</h4>
                    <div class="h-64 flex items-end gap-2 pt-8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $monthlyTrends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-100 rounded-t-lg relative group"
                                    style="height: <?php echo e(($month['total'] / max($maxMonthlyTotal, 1)) * 200); ?>px">
                                    <div
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block">
                                        <div class="bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                                            <?php echo e($month['month']); ?>: KES <?php echo e(number_format($month['total'], 2)); ?>

                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 mt-2"><?php echo e($month['short_label']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Savings Deductions Tab -->
            <div id="payrollSavingsContent" class="p-6 hidden">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Savings Deductions Management</h3>
                        <p class="text-gray-500 text-sm">Configure and manage member savings deduction rates</p>
                    </div>
                    <button onclick="addSavingsDeduction()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        + Add Deduction
                    </button>
                </div>

                <!-- Savings Deductions Table -->
                <div class="overflow-x-auto border border-gray-300 rounded-lg mb-6">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Member</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Deduction Rate</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Monthly Amount</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Total to Date</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Last Updated</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $savingsDeductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Calculate if deductions are configured
                                    $hasSalary = $deduction->basic_salary > 0;
                                    $hasDeduction = $deduction->monthly_amount > 0;
                                    $isConfigured = $hasSalary && $hasDeduction;

                                    // Format dates safely
                                    $startDateFormatted = $deduction->start_date ? $deduction->start_date->format('M Y') : 'N/A';
                                    $updatedDateFormatted = $deduction->updated_at ? $deduction->updated_at->format('d M Y') : 'N/A';
                                ?>

                                <tr class="hover:bg-gray-50 <?php echo e(!$isConfigured ? 'bg-yellow-50' : ''); ?>">
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 <?php echo e($isConfigured ? 'bg-green-100' : 'bg-yellow-100'); ?> rounded-full flex items-center justify-center mr-3">
                                                <span
                                                    class="<?php echo e($isConfigured ? 'text-green-700' : 'text-yellow-700'); ?> text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($deduction->user->name, 0, 1))); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm"><?php echo e($deduction->user->name); ?></p>
                                                <p class="text-gray-500 text-xs"><?php echo e($deduction->user->employee_number); ?></p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->basic_salary > 0): ?>
                                                    <p class="text-gray-500 text-xs">Salary: KES
                                                        <?php echo e(number_format($deduction->basic_salary, 2)); ?></p>
                                                <?php else: ?>
                                                    <p class="text-red-500 text-xs">⚠️ Salary not set</p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->deduction_rate > 0): ?>
                                                <span
                                                    class="text-lg font-bold text-green-600"><?php echo e(number_format($deduction->deduction_rate, 1)); ?>%</span>
                                                <input type="range" min="0" max="20" step="0.5"
                                                    value="<?php echo e(number_format($deduction->deduction_rate, 1)); ?>"
                                                    onchange="updateSavingsRate(<?php echo e($deduction->user->id); ?>, this.value)"
                                                    class="w-24 accent-green-600">
                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm">Not set</span>
                                                <input type="range" min="0" max="20" step="0.5" value="0"
                                                    onchange="updateSavingsRate(<?php echo e($deduction->user->id); ?>, this.value)"
                                                    class="w-24 accent-gray-400">
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <p class="text-gray-500 text-xs mt-1">Of monthly salary</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->monthly_amount > 0): ?>
                                            <p class="font-bold text-gray-900">KES
                                                <?php echo e(number_format($deduction->monthly_amount, 2)); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($deduction->deduction_day); ?>th of month</p>
                                        <?php else: ?>
                                            <p class="text-gray-400 text-sm">KES 0.00</p>
                                            <p class="text-gray-500 text-xs">No deduction configured</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->total_deducted > 0): ?>
                                            <p class="font-medium text-gray-900">KES
                                                <?php echo e(number_format($deduction->total_deducted, 2)); ?></p>
                                            <p class="text-gray-500 text-xs">Since <?php echo e($startDateFormatted); ?></p>
                                        <?php else: ?>
                                            <p class="font-medium text-gray-400">KES 0.00</p>
                                            <p class="text-gray-500 text-xs">No deductions yet</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="text-sm text-gray-900"><?php echo e($updatedDateFormatted); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduction->updatedBy && $deduction->updatedBy->name): ?>
                                            <p class="text-gray-500 text-xs">By <?php echo e($deduction->updatedBy->name); ?></p>
                                        <?php else: ?>
                                            <p class="text-gray-500 text-xs">By System</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="editSavingsDeduction(<?php echo e($deduction->user->id); ?>)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                <?php echo e($isConfigured ? 'Edit' : 'Setup'); ?>

                                            </button>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isConfigured): ?>
                                                <button onclick="pauseSavingsDeduction(<?php echo e($deduction->user->id); ?>)"
                                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                    <?php echo e($deduction->is_active ? 'Pause' : 'Resume'); ?>

                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Update Section -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h4 class="font-semibold text-blue-900 mb-4">Bulk Update Savings Rates</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-blue-700 mb-2">Select Members</label>
                            <select multiple class="w-full border border-blue-300 rounded-lg p-2 text-sm" size="5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?> (<?php echo e($member->employee_number); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-blue-700 mb-2">New Deduction Rate (%)</label>
                            <input type="number" min="0" max="20" step="0.5" value="5"
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg text-sm" id="bulkRate">
                        </div>
                        <div class="flex items-end">
                            <button onclick="applyBulkSavingsRate()"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium">
                                Apply to Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Deductions Tab -->
            <div id="payrollLoansContent" class="p-6 hidden">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Loan Repayment Deductions</h3>
                    <p class="text-gray-500 text-sm">Active loan repayments processed through payroll</p>
                </div>

                <!-- Active Loan Repayments -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Summary Card -->
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-semibold text-purple-900">Loan Repayment Summary</h4>
                                <p class="text-purple-600 text-sm">Current Month</p>
                            </div>
                            <span class="text-purple-600 text-2xl">🏦</span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-purple-700 text-sm">Total Repayments:</span>
                                <span class="font-bold text-purple-900">KES
                                    <?php echo e(number_format($loanRepayments['total_amount'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-purple-700 text-sm">Active Loans:</span>
                                <span class="font-medium text-purple-900"><?php echo e($loanRepayments['total_loans']); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-purple-700 text-sm">Members:</span>
                                <span class="font-medium text-purple-900"><?php echo e($loanRepayments['total_members']); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-purple-700 text-sm">Defaulted:</span>
                                <span class="font-medium text-red-600"><?php echo e($loanRepayments['defaulted_count']); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Loan Repayment Breakdown -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Repayment Breakdown</h4>
                        <div class="space-y-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loanRepayments['breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breakdown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-purple-600 font-bold text-sm"><?php echo e($loop->iteration); ?></span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm"><?php echo e($breakdown['purpose']); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($breakdown['member_name']); ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-purple-600">KES
                                            <?php echo e(number_format($breakdown['monthly_payment'], 2)); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($breakdown['loan_number']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Loan Deductions Table -->
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Loan Details</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Member</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Monthly Payment</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Balance</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Next Deduction</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeLoanDeductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <p class="font-bold text-gray-900 text-sm">#<?php echo e($loan->loan_number); ?></p>
                                                        <p class="text-gray-500 text-xs"><?php echo e($loan->purpose); ?></p>
                                                        <p class="text-gray-500 text-xs">Disbursed:
                                                            <?php echo e($loan->disbursed_date?->format('d M Y') ?? 'N/A'); ?></p>
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
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <p class="font-bold text-purple-600">KES <?php echo e(number_format($loan->monthly_payment, 2)); ?>

                                                        </p>
                                                        <p class="text-gray-500 text-xs">Auto-deduct from payroll</p>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <p class="font-medium text-gray-900">KES
                                                            <?php echo e(number_format($loan->remaining_balance, 2)); ?></p>
                                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                                            <div class="bg-green-600 h-1.5 rounded-full"
                                                                style="width: <?php echo e($loan->percentage_paid); ?>%"></div>
                                                        </div>
                                                        <p class="text-gray-500 text-xs mt-1"><?php echo e(number_format($loan->percentage_paid, 1)); ?>%
                                                            paid</p>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <p class="font-medium text-gray-900">
                                                            <?php echo e($loan->next_payment_date?->format('d M Y') ?? 'N/A'); ?></p>
                                                        <p class="text-gray-500 text-xs">Day <?php echo e($loan->deduction_day); ?> of month</p>
                                                    </td>
                                                    <td class="px-4 py-3 border border-gray-300">
                                                        <span class="px-2 py-1 text-xs rounded-full font-medium border 
                                                            <?php echo e($loan->status === 'active' ? 'bg-green-100 text-green-800 border-green-200' :
                                ($loan->status === 'defaulted' ? 'bg-red-100 text-red-800 border-red-200' :
                                    'bg-orange-100 text-orange-800 border-orange-200')); ?>">
                                                            <?php echo e(ucfirst($loan->status)); ?>

                                                        </span>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->is_defaulted): ?>
                                                            <p class="text-red-600 text-xs mt-1"><?php echo e($loan->days_late); ?> days late</p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deduction Settings Tab -->
            <div id="payrollSettingsContent" class="p-6 hidden">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Payroll Deduction Settings</h3>
                    <p class="text-gray-500 text-sm">Configure system-wide payroll deduction settings</p>
                </div>

                <!-- Settings Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- General Settings -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">General Settings</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Deduction Day</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 28; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e($i == 25 ? 'selected' : ''); ?>><?php echo e($i); ?>th of each month
                                        </option>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Savings Deduction Rate
                                    (%)</label>
                                <input type="number" min="0" max="50" step="0.5" value="20"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <p class="text-gray-500 text-xs mt-1">Maximum percentage of basic salary for savings</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Net Salary (%)</label>
                                <input type="number" min="0" max="100" step="1" value="60"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <p class="text-gray-500 text-xs mt-1">Minimum net salary after all deductions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Notification & Alerts</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Email Notifications</p>
                                    <p class="text-gray-500 text-xs">Send email alerts for deductions</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" checked class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">SMS Alerts</p>
                                    <p class="text-gray-500 text-xs">Send SMS alerts for deductions</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Auto-approve Deductions</p>
                                    <p class="text-gray-500 text-xs">Automatically approve monthly deductions</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <button onclick="saveSettings()"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Export/Import Section -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h4 class="font-semibold text-blue-900 mb-4">Data Management</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button onclick="exportDeductionTemplates()"
                            class="bg-white hover:bg-gray-50 text-blue-700 border border-blue-300 py-3 rounded-lg font-medium flex items-center justify-center gap-2">
                            📥 Export Template
                        </button>
                        <button onclick="importDeductionData()"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2">
                            📤 Import Deductions
                        </button>
                    </div>
                </div>
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
                    <button onclick="processMonthlyDeductions()"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                        <span>🏦</span> Process Monthly Deductions
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

    <!-- JavaScript for Payroll Deductions -->
    <script>
    // Payroll Tab Switching
    function switchTab(tabName) {
        // Hide all payroll content
        ['payrollAll', 'payrollMonthly', 'payrollSavings', 'payrollLoans', 'payrollSettings'].forEach(tab => {
            const content = document.getElementById(tab + 'Content');
            const tabBtn = document.getElementById(tab + 'Tab');
            if (content) content.classList.add('hidden');
            if (tabBtn) {
                tabBtn.classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
                tabBtn.classList.add('text-gray-500');
            }
        });

        // Hide all savings tabs
        ['accounts', 'withdrawals', 'transactions', 'topsavers'].forEach(tab => {
            const content = document.getElementById(tab + 'Content');
            const tabBtn = document.getElementById(tab + 'Tab');
            if (content) content.classList.add('hidden');
            if (tabBtn) {
                tabBtn.classList.remove('border-b-2', 'border-green-600', 'text-green-700');
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
            selectedTab.classList.add('border-b-2', 'border-blue-600', 'text-blue-700');
            selectedTab.classList.remove('text-gray-500');
        }
    }

    // Member Deduction Management
    function viewMemberDeductions(memberId) {
        window.location.href = `/treasurer/members/${memberId}/deductions`;
    }

    function editDeductions(memberId) {
        // Create modal for editing deductions - UPDATED TO USE MONTHLY_SALARY AND MONTHLY_SAVINGS
        const modalHtml = `
            <div id="editDeductionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <div class="p-4 border-b border-gray-300">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Member Deductions</h3>
                            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                                ✕
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Salary (KES)</label>
                                <input type="number" id="monthlySalary" min="0" step="1000" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                       placeholder="Enter monthly salary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Savings Amount (KES)</label>
                                <input type="number" id="monthlySavings" min="0" step="100" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                       placeholder="Enter monthly savings amount">
                                <p class="text-gray-500 text-xs mt-1">Actual amount deducted from salary</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Loan Repayment Adjustment</label>
                                <input type="number" id="loanAdjustment" min="0" step="100" value="0" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                       placeholder="Additional loan payment (optional)">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="pauseDeductions" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="pauseDeductions" class="ml-2 text-sm text-gray-700">Pause deductions for this month</label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                <textarea id="deductionNotes" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                          placeholder="Reason for adjustment..."></textarea>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                            <button onclick="closeEditModal()"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button onclick="saveDeductionChanges(${memberId})"
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('editDeductionModal');
        if (existingModal) existingModal.remove();

        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    function closeEditModal() {
        const modal = document.getElementById('editDeductionModal');
        if (modal) modal.remove();
    }

    async function saveDeductionChanges(memberId) {
        const monthlySalary = document.getElementById('monthlySalary').value;
        const monthlySavings = document.getElementById('monthlySavings').value;
        const loanAdjustment = document.getElementById('loanAdjustment').value;
        const pauseDeductions = document.getElementById('pauseDeductions').checked;
        const notes = document.getElementById('deductionNotes').value;

        try {
            const response = await fetch(`/treasurer/members/${memberId}/update-payroll`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    monthly_salary: monthlySalary,
                    monthly_savings: monthlySavings,
                    loan_adjustment: loanAdjustment,
                    pause_deductions: pauseDeductions,
                    notes: notes
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                alert('✅ Deductions updated successfully!');
                closeEditModal();
                // Refresh the page or update the table
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Failed to update deductions');
            }
        } catch (error) {
            alert(`❌ Error: ${error.message}`);
        }
    }

    // ✅ UPDATED: Savings Deduction Management - Now using monthly_salary and monthly_savings
    function updateSavingsRate(userId, newRate) {
        if (confirm(`Change savings deduction rate to ${newRate}%?`)) {
            fetch(`/treasurer/members/${userId}/update-savings-rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ savings_rate: newRate })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successMsg = document.createElement('div');
                        successMsg.className = 'fixed top-4 right-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow-lg z-50';
                        successMsg.textContent = `Rate updated to ${newRate}%`;
                        document.body.appendChild(successMsg);
                        setTimeout(() => successMsg.remove(), 3000);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        }
    }

    // ✅ UPDATED: Edit savings deduction modal
    function editSavingsDeduction(userId) {
        const modalHtml = `
            <div id="setupModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl w-full max-w-md">
                    <div class="p-4 border-b border-gray-300">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-900">Configure Member Deductions</h3>
                            <button onclick="closeSetupModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                                ✕
                            </button>
                        </div>
                    </div>
                    
                    <form id="setupForm" class="p-4 space-y-4">
                        <input type="hidden" name="user_id" value="${userId}">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Salary (KES)*</label>
                            <input type="number" name="monthly_salary" required min="10000" step="1000"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter monthly salary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Savings Amount (KES)*</label>
                            <input type="number" name="monthly_savings" required min="0" step="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter monthly savings amount">
                            <p class="text-gray-500 text-xs mt-1">This is the actual amount deducted</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deduction Day of Month</label>
                            <select name="deduction_day" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 28; $i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e($i == 25 ? 'selected' : ''); ?>><?php echo e($i); ?>th</option>
                                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="flex gap-3 pt-4">
                            <button type="button" onclick="closeSetupModal()"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                Save Configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('setupModal');
        if (existingModal) existingModal.remove();

        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Handle form submission
        document.getElementById('setupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            setupMemberDeductions(this, userId);
        });
    }

    async function setupMemberDeductions(form, userId) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<span class="animate-spin">⏳</span> Saving...';
        submitBtn.disabled = true;

        try {
            const formData = new FormData(form);
            const data = {
                _token: formData.get('_token'),
                monthly_salary: parseFloat(formData.get('monthly_salary')),
                monthly_savings: parseFloat(formData.get('monthly_savings')),
                deduction_day: formData.get('deduction_day'),
            };

            const response = await fetch(`/treasurer/members/${userId}/setup-deductions`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': data._token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const responseData = await response.json();

            if (response.ok && responseData.success) {
                alert('✅ Member deduction configuration saved!');
                closeSetupModal();
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(responseData.message || 'Setup failed');
            }
        } catch (error) {
            alert(`❌ Error: ${error.message}`);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    function closeSetupModal() {
        const modal = document.getElementById('setupModal');
        if (modal) modal.remove();
    }

    function pauseSavingsDeduction(userId) {
        const action = confirm('Pause this savings deduction?');
        fetch(`/treasurer/members/${userId}/toggle-deduction`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                }
            });
    }

    function applyBulkSavingsRate() {
        const selectedMembers = Array.from(document.querySelectorAll('select option:checked')).map(opt => opt.value);
        const newRate = document.getElementById('bulkRate').value;

        if (selectedMembers.length === 0) {
            alert('Please select at least one member');
            return;
        }

        if (confirm(`Apply ${newRate}% savings rate to ${selectedMembers.length} members?`)) {
            fetch('/treasurer/bulk-update-savings-rates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    member_ids: selectedMembers,
                    savings_rate: newRate
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`✅ Updated ${data.updated_count} members successfully`);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        }
    }

    // Payroll Processing
    function generatePayrollReport() {
        const month = document.getElementById('payrollMonthFilter').value;
        window.location.href = `/treasurer/export-payroll-deductions?month=${month}`;
    }

    function loadMonthSummary() {
        const month = document.getElementById('monthSelect').value;
        // Reload page with month parameter
        window.location.href = window.location.pathname + `?month=${month}`;
    }

    function approveAllDeductions() {
        if (confirm('Approve all pending deductions for this month?')) {
            fetch('/treasurer/payroll/approve-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`✅ Approved ${data.count} deductions`);
                        location.reload();
                    }
                });
        }
    }

    function exportPayrollFile() {
        window.location.href = '/treasurer/export-payroll-deductions';
    }

    function processMonthlyDeductions() {
        if (confirm('Process all monthly deductions for the current month?')) {
            fetch('/treasurer/process-monthly-deductions', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`✅ Processed ${data.processed_count} deductions totaling KES ${data.total_amount.toLocaleString()}`);
                        location.reload();
                    }
                });
        }
    }

    // Settings Management
    function saveSettings() {
        // Collect all settings values
        const settings = {
            deduction_day: document.querySelector('select').value,
            max_savings_rate: document.querySelector('input[type="number"]').value,
            min_net_salary: document.querySelectorAll('input[type="number"]')[1].value,
            email_notifications: document.querySelectorAll('input[type="checkbox"]')[0].checked,
            sms_alerts: document.querySelectorAll('input[type="checkbox"]')[1].checked,
            auto_approve: document.querySelectorAll('input[type="checkbox"]')[2].checked
        };

        fetch('/treasurer/settings/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(settings)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Settings saved successfully');
                }
            });
    }

    function exportDeductionTemplates() {
        window.location.href = '/treasurer/payroll/templates/export';
    }

    function importDeductionData() {
        window.location.href = '/treasurer/import-payroll-data';
    }

    // Member-specific actions
    function manageDeductions(userId) {
        window.location.href = `/treasurer/members/${userId}/deductions`;
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize payroll tab as active
        switchTab('payrollAll');

        // Add search functionality
        document.getElementById('searchAccounts')?.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#accountsContent tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>

<!-- Existing JavaScript functions from original page -->
<script>
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/savings-with-deductions.blade.php ENDPATH**/ ?>