

<?php $__env->startSection('title', 'Loan Detail - ' . $loan->loan_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">
                        Loan: <?php echo e($loan->loan_number); ?>

                    </h1>
                    <p class="text-gray-500 mt-1">View loan details and payment history</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Applied</p>
                    <p class="text-lg font-semibold text-gray-800">
                        <?php echo e($loan->applied_date ? $loan->applied_date->format('d M Y') : 'N/A'); ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Applicant Information -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Applicant Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Full Name</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->name); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Employee Number</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->employee_number); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Email</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->email); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Phone</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->phone); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Loan Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Loan Amount</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Interest Rate</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($loan->interest_rate); ?>%</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Loan Period</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->period_months); ?> months</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Monthly Payment</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->monthly_payment, 2)); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Interest Amount</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->interest_amount, 2)); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Total Repayable</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->total_repayable, 2)); ?></p>
                        </div>

                        <div class="md:col-span-2 p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Purpose</p>
                            <p class="text-gray-900 mt-1 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <?php echo e($loan->purpose ?? 'General Purpose'); ?></p>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($loan->support_document)): ?>
                            <div class="md:col-span-2 p-3 border border-gray-200 rounded bg-white">
                                <p class="text-sm text-gray-500 font-medium">Support Document</p>
                                <p class="text-sm text-gray-800 mt-2">
                                    <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" target="_blank"
                                        class="text-blue-600 hover:underline">Open support document</a>
                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment History</h3>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->payments && $loan->payments->count()): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="p-3 border border-gray-200">#</th>
                                        <th class="p-3 border border-gray-200">Date</th>
                                        <th class="p-3 border border-gray-200">Amount</th>
                                        <th class="p-3 border border-gray-200">Principal</th>
                                        <th class="p-3 border border-gray-200">Interest</th>
                                        <th class="p-3 border border-gray-200">Processed By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loan->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="p-3 border border-gray-200"><?php echo e($idx + 1); ?></td>
                                            <td class="p-3 border border-gray-200">
                                                <?php echo e(optional($payment->payment_date)->format('d M Y')); ?></td>
                                            <td class="p-3 border border-gray-200">KES <?php echo e(number_format($payment->amount, 2)); ?></td>
                                            <td class="p-3 border border-gray-200">KES
                                                <?php echo e(number_format($payment->principal ?? 0, 2)); ?></td>
                                            <td class="p-3 border border-gray-200">KES
                                                <?php echo e(number_format($payment->interest ?? 0, 2)); ?></td>
                                            <td class="p-3 border border-gray-200">
                                                <?php echo e($payment->processedBy->name ?? ($payment->postedBy->name ?? 'System')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">No payments recorded yet.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            </div>

            <!-- Sidebar Summary -->
            <div class="space-y-6">

                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Loan Summary</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-green-800">Status:</span>
                            <span class="font-semibold text-gray-900"><?php echo e(ucfirst($loan->status)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">Amount Paid:</span>
                            <span class="font-semibold text-gray-900">KES <?php echo e(number_format($loan->amount_paid, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">Remaining:</span>
                            <span class="font-semibold text-gray-900">KES
                                <?php echo e(number_format($loan->remaining_balance, 2)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">Next Payment:</span>
                            <span
                                class="font-semibold text-gray-900"><?php echo e($loan->next_payment_date ? $loan->next_payment_date->format('d M Y') : 'N/A'); ?></span>
                        </div>
                    </div>
                </div>

                <a href="<?php echo e(route('treasurer.loans')); ?>"
                    class="block text-center px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">←
                    Back to Loans</a>

            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/loan-detail.blade.php ENDPATH**/ ?>