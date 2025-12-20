

<?php $__env->startSection('title', 'Loan Approval - ' . $loan->loan_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">
                        Loan Approval: <?php echo e($loan->loan_number); ?>

                    </h1>
                    <p class="text-gray-500 mt-1">Review applicant details and approve or reject</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Applied</p>
                    <p class="text-lg font-semibold text-gray-800"><?php echo e($loan->applied_date->format('d M Y')); ?></p>
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
                            <p class="text-sm text-gray-500 font-medium">Department</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->department ?? 'N/A'); ?></p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Position</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->position ?? 'N/A'); ?></p>
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
                            <p class="text-gray-900 mt-1 bg-gray-50 p-4 rounded-lg border border-gray-200"><?php echo e($loan->purpose ?? 'General Purpose'); ?></p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($loan->support_document)): ?>
                            <div class="md:col-span-2 p-3 border border-gray-200 rounded bg-white">
                                <p class="text-sm text-gray-500 font-medium">Support Document</p>
                                <p class="text-sm text-gray-800 mt-2">
                                    <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" target="_blank" class="text-blue-600 hover:underline">Open support document</a>
                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Approval Panel -->
            <div class="space-y-6">

                <!-- Summary Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Approval Summary</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-blue-800">Status:</span>
                            <span class="font-semibold text-yellow-600">⏳ Pending</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-800">Applied:</span>
                            <span class="font-semibold text-blue-900"><?php echo e($loan->applied_date->format('d M Y')); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-800">Waiting:</span>
                            <span class="font-semibold text-blue-900"><?php echo e($loan->applied_date->diffForHumans()); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Approval Form -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Decision</h3>

                    <div class="space-y-4">

                        <!-- Approve Button -->
                        <form method="POST" action="<?php echo e(route('secretary.loans.approve', $loan->id)); ?>"
                            onsubmit="return confirm('Approve this loan application?');">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition">
                                ✅ Approve Loan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form method="POST" action="<?php echo e(route('secretary.loans.reject', $loan->id)); ?>" id="rejectForm">
                            <?php echo csrf_field(); ?>
                            <div class="space-y-3">
                                <textarea name="rejection_reason"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    rows="3" placeholder="Explain why this loan is being rejected..." required></textarea>

                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition"
                                    onclick="return confirm('Reject this loan application?');">
                                    ❌ Reject Loan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Back Button -->
                <a href="<?php echo e(route('secretary.loan-approvals')); ?>"
                    class="block text-center px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    ← Back to Approvals
                </a>

            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/loan-approval-detail.blade.php ENDPATH**/ ?>