

<?php $__env->startSection('title', 'Loan Details - ' . $loan->loan_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight"><?php echo e($loan->loan_number); ?></h1>
                    <p class="text-gray-500 mt-1">Loan details and payment history</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'pending'): ?>
                        <span
                            class="px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-700 rounded-full inline-block mt-1">
                            ⏳ Pending Review
                        </span>
                    <?php elseif($loan->status === 'approved'): ?>
                        <span
                            class="px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full inline-block mt-1">
                            ✅ Approved
                        </span>
                    <?php elseif($loan->status === 'rejected'): ?>
                        <span class="px-3 py-1 text-sm font-semibold bg-red-100 text-red-700 rounded-full inline-block mt-1">
                            ❌ Rejected
                        </span>
                    <?php elseif($loan->status === 'disbursed'): ?>
                        <span class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-700 rounded-full inline-block mt-1">
                            💸 Disbursed
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Loan Overview -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Loan Overview</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Loan Amount</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Interest Rate</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($loan->interest_rate); ?>%</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Total Repayable</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->total_repayable, 2)); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Monthly Payment</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->monthly_payment, 2)); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Timeline</h2>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <span class="text-green-600 text-xl">📝</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Applied</p>
                                <p class="text-sm text-gray-500"><?php echo e($loan->applied_date->format('d M Y \a\t H:i')); ?></p>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->approved_date): ?>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                                        <span class="text-blue-600 text-xl">✅</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Approved</p>
                                    <p class="text-sm text-gray-500"><?php echo e($loan->approved_date->format('d M Y \a\t H:i')); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->approver): ?>
                                        <p class="text-sm text-gray-600 mt-1">By: <strong><?php echo e($loan->approver->name); ?></strong>
                                            (<?php echo e(ucfirst($loan->approver->role)); ?>)</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'rejected' && $loan->rejection_reason): ?>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                        <span class="text-red-600 text-xl">❌</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Rejected</p>
                                    <p class="text-sm text-gray-500"><?php echo e($loan->approved_date?->format('d M Y \a\t H:i')); ?></p>
                                    <p class="text-sm text-red-600 mt-1">Reason: <?php echo e($loan->rejection_reason); ?></p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->disbursed_date): ?>
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                                        <span class="text-purple-600 text-xl">💸</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Disbursed</p>
                                    <p class="text-sm text-gray-500"><?php echo e($loan->disbursed_date->format('d M Y \a\t H:i')); ?></p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->support_document): ?>
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Support Document</h2>
                        <p class="text-sm text-gray-700">Uploaded document to support your application.</p>
                        <p class="mt-3">
                            <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" target="_blank"
                                class="text-blue-600 hover:underline">Open document</a>
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Payment Schedule -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status !== 'rejected'): ?>
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Schedule</h2>

                <div class="space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount Paid:</span>
                        <span class="font-semibold text-gray-900">KES <?php echo e(number_format($loan->amount_paid, 2)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Remaining Balance:</span>
                        <span class="font-semibold text-gray-900">KES <?php echo e(number_format($remainingBalance, 2)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Progress:</span>
                        <span class="font-semibold text-gray-900"><?php echo e(number_format($percentagePaid, 1)); ?>%</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(min($percentagePaid, 100)); ?>%"></div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->payments && $loan->payments->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Date</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loan->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-gray-900 border border-gray-200">
                                            <?php echo e($payment->payment_date->format('d M Y')); ?></td>
                                        <td class="px-4 py-2 font-semibold text-gray-900 border border-gray-200">KES
                                            <?php echo e(number_format($payment->amount, 2)); ?></td>
                                        <td class="px-4 py-2 border border-gray-200">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->status === 'completed'): ?>
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">✓
                                                    Completed</span>
                                            <?php else: ?>
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded"><?php echo e(ucfirst($payment->status)); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-6">No payments recorded yet</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">

        <!-- Summary Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Summary</h3>

            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-blue-800">Loan Period:</span>
                    <p class="font-semibold text-blue-900"><?php echo e($loan->period_months); ?> months</p>
                </div>
                <div>
                    <span class="text-blue-800">Expected Completion:</span>
                    <p class="font-semibold text-blue-900"><?php echo e($loan->expected_completion_date->format('d M Y')); ?></p>
                </div>
                <div class="pt-3 border-t border-blue-200">
                    <span class="text-blue-800">Payments Completed:</span>
                    <p class="font-semibold text-blue-900"><?php echo e($loan->months_paid); ?> / <?php echo e($loan->period_months); ?> months</p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'approved' && !$loan->disbursed_date): ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">⏳ Awaiting Disbursement</h3>
                <p class="text-sm text-yellow-800">Your loan has been approved. The Treasurer will process the disbursement
                    shortly.</p>
            </div>
        <?php elseif($loan->status === 'pending'): ?>
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">📋 Under Review</h3>
                <p class="text-sm text-blue-800">Your application is being reviewed. You'll be notified once a decision is made.
                </p>
            </div>
        <?php elseif($loan->status === 'rejected'): ?>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-2">❌ Application Rejected</h3>
                <p class="text-sm text-red-800">
                    <?php echo e($loan->rejection_reason ?? 'Your application could not be approved at this time.'); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Back Button -->
        <a href="<?php echo e(route('member.loans.index')); ?>"
            class="block text-center px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
            ← Back to Loans
        </a>

    </div>

    </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/show.blade.php ENDPATH**/ ?>