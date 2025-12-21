

<?php $__env->startSection('title', 'Payment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 p-6 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Payment Details</h1>
                    <p class="text-gray-600 mt-1">Reference: <?php echo e($payment->payment_ref); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-green-700">KES <?php echo e(number_format($payment->amount, 2)); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e($payment->payment_date->format('d F Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="p-6 space-y-6">
            <!-- Status Badge -->
            <div class="flex items-center justify-between">
                <div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        <?php echo e($payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           'bg-red-100 text-red-800')); ?>">
                        <?php echo e(ucfirst($payment->status)); ?>

                    </span>
                    <span class="ml-3 px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium capitalize">
                        <?php echo e($payment->payment_method); ?>

                    </span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->posted_date): ?>
                    <p class="text-sm text-gray-500">Posted: <?php echo e($payment->posted_date->format('d M Y, H:i')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Payment Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Payment Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium capitalize"><?php echo e($payment->payment_method); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reference Number:</span>
                                <span class="font-medium"><?php echo e($payment->reference_number ?? 'N/A'); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Date:</span>
                                <span class="font-medium"><?php echo e($payment->payment_date->format('d F Y')); ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->loan): ?>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Loan Details</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Loan Number:</span>
                                <span class="font-medium">#<?php echo e($payment->loan->loan_number); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Purpose:</span>
                                <span class="font-medium"><?php echo e($payment->loan->purpose); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Disbursed On:</span>
                                <span class="font-medium"><?php echo e($payment->loan->disbursed_date?->format('d M Y') ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->chequeRecord): ?>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Cheque Details</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Cheque Number:</span>
                                <span class="font-medium"><?php echo e($payment->chequeRecord->cheque_number); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bank:</span>
                                <span class="font-medium"><?php echo e($payment->chequeRecord->bank_name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Branch:</span>
                                <span class="font-medium"><?php echo e($payment->chequeRecord->bank_branch); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium capitalize"><?php echo e($payment->chequeRecord->status); ?></span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->chequeRecord->issue_date): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Issued Date:</span>
                                <span class="font-medium"><?php echo e($payment->chequeRecord->issue_date->format('d M Y')); ?></span>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->notes): ?>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Notes</h3>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg"><?php echo e($payment->notes); ?></p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Amount Breakdown -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->principal > 0 || $payment->interest > 0): ?>
            <div class="border-t pt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-4">Amount Breakdown</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-700">Principal Amount</p>
                        <p class="text-2xl font-bold text-blue-900">KES <?php echo e(number_format($payment->principal, 2)); ?></p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-green-700">Interest Amount</p>
                        <p class="text-2xl font-bold text-green-900">KES <?php echo e(number_format($payment->interest, 2)); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">KES <?php echo e(number_format($payment->amount, 2)); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t flex justify-between items-center">
            <a href="<?php echo e(route('member.payments.disbursed')); ?>" 
               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                ← Back to Payments
            </a>
            <div class="text-sm text-gray-500">
                Transaction ID: <?php echo e($payment->id); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/payment-details.blade.php ENDPATH**/ ?>