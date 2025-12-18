

<?php $__env->startSection('title', 'Cheque Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 font-sans">

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-green-700 font-bold text-lg">5</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Cheque Management</h1>
                </div>
                <p class="text-green-800">Issue, track, and reconcile cheque payments for loans and expenses</p>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-green-600 text-sm font-medium">Cheques to Issue</p>
                    <p class="text-4xl font-bold text-gray-900"><?php echo e($chequeStats['issued_cheques']); ?></p>
                    <p class="text-gray-500 text-xs mt-1">KES <?php echo e(number_format($chequeStats['total_amount_issued'], 2)); ?> total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cheque Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Cheques</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($chequeStats['total_cheques']); ?></p>
                    <p class="text-gray-500 text-sm mt-1">All time</p>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-xl">🏦</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Issued</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($chequeStats['issued_cheques']); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting clearance</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-xl">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Cleared</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($chequeStats['cleared_cheques']); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Processed successfully</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <span class="text-blue-600 text-xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Cancelled</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($chequeStats['cancelled_cheques']); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Voided cheques</p>
                </div>
                <div class="bg-red-50 p-3 rounded-xl">
                    <span class="text-red-600 text-xl">❌</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('issued')" id="issuedTab" 
                        class="px-6 py-4 font-medium border-b-2 border-orange-600 text-orange-700 whitespace-nowrap">
                    ⏳ Issued (<?php echo e($chequesByStatus['issued']->count()); ?>)
                </button>
                <button onclick="switchTab('cleared')" id="clearedTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Cleared (<?php echo e($chequesByStatus['cleared']->count()); ?>)
                </button>
                <button onclick="switchTab('cancelled')" id="cancelledTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ❌ Cancelled (<?php echo e($chequesByStatus['cancelled']->count()); ?>)
                </button>
                <button onclick="switchTab('recent')" id="recentTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📋 Recent Activity (<?php echo e($recentCheques->count()); ?>)
                </button>
            </nav>
        </div>

        <!-- Issued Cheques -->
        <div id="issuedContent" class="p-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chequesByStatus['issued']->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Cheque Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Beneficiary</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Bank Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Issue Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chequesByStatus['issued']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">#<?php echo e($cheque->cheque_number); ?></p>
                                <p class="text-gray-500 text-sm">KES <?php echo e(number_format($cheque->amount, 2)); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e(ucfirst(str_replace('_', ' ', $cheque->purpose))); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->loan): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->loan->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Loan #<?php echo e($cheque->loan->loan_number); ?></p>
                                <?php elseif($cheque->savingsTransaction): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->savingsTransaction->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Savings Withdrawal</p>
                                <?php else: ?>
                                <p class="text-gray-500">Expense Payment</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900 text-sm"><?php echo e($cheque->bank_name); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($cheque->account_number); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($cheque->bank_branch); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900"><?php echo e($cheque->issue_date?->format('d M Y') ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-xs">Issued by <?php echo e($cheque->issuedBy->name ?? 'N/A'); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <button onclick="markCleared(<?php echo e($cheque->id); ?>)" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Mark Cleared
                                    </button>
                                    <button onclick="cancelCheque(<?php echo e($cheque->id); ?>)" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Cancel
                                    </button>
                                    <button onclick="printCheque(<?php echo e($cheque->id); ?>)" 
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                        Print
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
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Issued Cheques</h3>
                <p class="text-gray-500">All cheques have been cleared or cancelled.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Cleared Cheques -->
        <div id="clearedContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chequesByStatus['cleared']->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Cheque Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Beneficiary</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Clearance Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chequesByStatus['cleared']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">#<?php echo e($cheque->cheque_number); ?></p>
                                <p class="text-gray-500 text-sm">KES <?php echo e(number_format($cheque->amount, 2)); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e(ucfirst(str_replace('_', ' ', $cheque->purpose))); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->loan): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->loan->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Loan disbursement</p>
                                <?php elseif($cheque->savingsTransaction): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->savingsTransaction->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Savings withdrawal</p>
                                <?php else: ?>
                                <p class="text-gray-500">Expense payment</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900"><?php echo e($cheque->clearance_date?->format('d M Y') ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-xs">Cleared by <?php echo e($cheque->clearedBy->name ?? 'N/A'); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                    Cleared
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <button onclick="viewCheque(<?php echo e($cheque->id); ?>)" 
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <div class="text-4xl mb-4">🏦</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Cleared Cheques</h3>
                <p class="text-gray-500">Cleared cheque history will appear here.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Cancelled Cheques -->
        <div id="cancelledContent" class="p-6 hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chequesByStatus['cancelled']->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Cheque Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Beneficiary</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Cancellation Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chequesByStatus['cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">#<?php echo e($cheque->cheque_number); ?></p>
                                <p class="text-gray-500 text-sm">KES <?php echo e(number_format($cheque->amount, 2)); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e(ucfirst(str_replace('_', ' ', $cheque->purpose))); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->loan): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->loan->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Loan #<?php echo e($cheque->loan->loan_number); ?></p>
                                <?php elseif($cheque->savingsTransaction): ?>
                                <p class="font-medium text-gray-900"><?php echo e($cheque->savingsTransaction->user->name ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-sm">Savings withdrawal</p>
                                <?php else: ?>
                                <p class="text-gray-500">Expense payment</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900"><?php echo e($cheque->cancelled_date?->format('d M Y') ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-xs">Cancelled by <?php echo e($cheque->cancelledBy->name ?? 'N/A'); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-red-600 text-sm"><?php echo e($cheque->cancellation_reason ?? 'No reason provided'); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <button onclick="viewCheque(<?php echo e($cheque->id); ?>)" 
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Cancelled Cheques</h3>
                <p class="text-gray-500">No cheques have been cancelled.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div id="recentContent" class="p-6 hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Cheque Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Purpose</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentCheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cheque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">#<?php echo e($cheque->cheque_number); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($cheque->bank_name); ?></p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $cheque->purpose))); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->loan): ?>
                                <p class="text-gray-500 text-xs">Loan: <?php echo e($cheque->loan->loan_number); ?></p>
                                <?php elseif($cheque->savingsTransaction): ?>
                                <p class="text-gray-500 text-xs">Withdrawal</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->status === 'issued'): ?>
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">Issued</span>
                                <?php elseif($cheque->status === 'cleared'): ?>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Cleared</span>
                                <?php else: ?>
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Cancelled</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900"><?php echo e($cheque->issue_date?->format('d M Y') ?? 'N/A'); ?></p>
                                <p class="text-gray-500 text-xs">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cheque->status === 'cleared'): ?>
                                    Cleared: <?php echo e($cheque->clearance_date?->format('d M')); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">KES <?php echo e(number_format($cheque->amount, 2)); ?></p>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cheque Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cheque Operations</h3>
            <div class="space-y-3">
                <button onclick="issueNewCheque()" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                    <span>➕</span> Issue New Cheque
                </button>
                <button onclick="batchProcessCheques()" 
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                    <span>🏦</span> Batch Clear Cheques
                </button>
                <button onclick="uploadBankStatement()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                    <span>📄</span> Upload Bank Statement
                </button>
                <button onclick="reconcileCheques()" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                    <span>🔍</span> Reconcile Outstanding
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cheque Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('outstanding')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>⏳ Outstanding Cheques Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('cleared')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>✅ Cleared Cheques Summary</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('cancelled')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>❌ Cancelled Cheques Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportChequeData()" 
                        class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center">
                    <span>💾 Export Cheque Register</span>
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
    ['issued', 'cleared', 'cancelled', 'recent'].forEach(tab => {
        document.getElementById(tab + 'Content').classList.add('hidden');
        document.getElementById(tab + 'Tab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
        document.getElementById(tab + 'Tab').classList.add('text-gray-500');
    });
    
    // Show selected content
    document.getElementById(tabName + 'Content').classList.remove('hidden');
    
    // Activate selected tab
    document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-orange-600', 'text-orange-700');
    document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
}

// Action functions
function markCleared(chequeId) {
    const clearanceDate = prompt('Clearance date (YYYY-MM-DD):', new Date().toISOString().split('T')[0]);
    if (clearanceDate) {
        const notes = prompt('Clearance notes (optional):');
        fetch(`/treasurer/cheques/${chequeId}/clear`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                clearance_date: clearanceDate,
                clearance_notes: notes || ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cheque marked as cleared!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function cancelCheque(chequeId) {
    const reason = prompt('Reason for cancellation:');
    if (reason) {
        fetch(`/treasurer/cheques/${chequeId}/cancel`, {
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
                alert('Cheque cancelled.');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function printCheque(chequeId) {
    window.open(`/treasurer/cheques/${chequeId}/print`, '_blank');
}

function viewCheque(chequeId) {
    window.location.href = `/treasurer/cheques/${chequeId}`;
}

function issueNewCheque() {
    window.location.href = '/treasurer/cheques/create';
}

function batchProcessCheques() {
    const count = <?php echo e($chequesByStatus['issued']->count()); ?>;
    if (count > 0 && confirm(`Mark all ${count} issued cheques as cleared?`)) {
        fetch('/treasurer/cheques/batch-clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Cleared ${data.count} cheques successfully!`);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function uploadBankStatement() {
    window.location.href = '/treasurer/cheques/upload-statement';
}

function reconcileCheques() {
    window.location.href = '/treasurer/reconciliation';
}

function generateReport(type) {
    window.location.href = `/treasurer/reports/cheques/${type}`;
}

function exportChequeData() {
    if (confirm('Export cheque register to Excel?')) {
        window.location.href = '/treasurer/cheques/export';
    }
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('issued');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/cheques.blade.php ENDPATH**/ ?>