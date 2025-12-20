<?php $__env->startSection('title', 'Loan Approval - ' . $loan->user->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Back Button -->
        <div>
            <a href="<?php echo e(route('chairman.loan-approvals')); ?>" class="text-indigo-600 hover:text-indigo-700 font-medium">
                ← Back to Approvals
            </a>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-2xl p-6 border border-indigo-200">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Review Loan Application</h1>
                    <p class="text-indigo-800 mt-2">Loan #<?php echo e($loan->loan_number); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-indigo-900 font-semibold">Applied: <?php echo e($loan->created_at->format('d M Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Loan Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Member Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Member Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Full
                                    Name</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->name); ?></p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Employee
                                    Number</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->employee_number); ?></p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Department</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->department ?? 'N/A'); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Employment Info -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Position</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->position ?? 'N/A'); ?></p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Employment
                                    Type</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    <?php echo e($loan->user->employment_type ?? 'N/A'); ?>

                                </p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Member
                                    Since</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    <?php echo e($loan->user->created_at->format('d M Y')); ?>

                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Next of Kin -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Email</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->email); ?></p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->user->nextOfKin): ?>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Next of
                                    Kin</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->user->nextOfKin->name); ?></p>
                                <p class="text-sm text-gray-600 mt-1"><?php echo e($loan->user->nextOfKin->phone_number); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Loan Details</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Loan
                                Type</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e(ucfirst($loan->loan_type)); ?></p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Requested
                                Amount</label>
                            <p class="text-xl font-bold text-green-600 mt-1">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Period
                                (Months)</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->period_months); ?></p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Interest
                                Rate</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1"><?php echo e($loan->interest_rate); ?>%</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Interest
                                Amount</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->interest_amount, 2)); ?>

                            </p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Total
                                Repayable</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                <?php echo e(number_format($loan->total_repayable, 2)); ?>

                            </p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Monthly
                                Payment</label>
                            <p class="text-lg font-semibold text-blue-600 mt-1">KES
                                <?php echo e(number_format($loan->monthly_payment, 2)); ?>

                            </p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <label
                            class="block text-xs uppercase tracking-wider font-semibold text-gray-600 mb-2">Purpose</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3"><?php echo e($loan->purpose ?? 'Not specified'); ?></p>
                    </div>
                    <!-- Add this to your loan details section -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->support_document): ?>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Supporting Document</h4>
                            
                            <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <?php
                                        $fileExt = pathinfo($loan->support_document, PATHINFO_EXTENSION);
                                        $icon = 'fa-file';
                                        $color = 'text-blue-500';
                                        
                                        if (in_array($fileExt, ['pdf'])) {
                                            $icon = 'fa-file-pdf';
                                            $color = 'text-red-500';
                                        } elseif (in_array($fileExt, ['doc', 'docx'])) {
                                            $icon = 'fa-file-word';
                                            $color = 'text-blue-600';
                                        } elseif (in_array($fileExt, ['jpg', 'jpeg', 'png'])) {
                                            $icon = 'fa-file-image';
                                            $color = 'text-green-500';
                                        }
                                    ?>
                                    
                                    <div class="flex items-center justify-center w-12 h-12 bg-white rounded-lg border border-gray-200 mr-4">
                                        <i class="fas <?php echo e($icon); ?> <?php echo e($color); ?> text-xl"></i>
                                    </div>
                                    
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            Loan Application Form
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Uploaded by: <?php echo e($loan->application_type === 'assisted' ? 'Secretary' : 'Member'); ?>

                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($fileExt, ['jpg', 'jpeg', 'png'])): ?>
                                        <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" 
                                        target="_blank"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium flex items-center">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" 
                                    download
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium flex items-center">
                                        <i class="fas fa-download mr-2"></i> Download
                                    </a>
                                </div>
                            </div>
                            
                            <p class="text-xs text-gray-500 mt-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->application_type === 'assisted'): ?>
                                    <i class="fas fa-user-tie mr-1"></i> Assisted by Secretary: 
                                    <?php echo e($loan->assistedBy->name ?? 'Unknown'); ?>

                                <?php else: ?>
                                    <i class="fas fa-user mr-1"></i> Self-applied by member
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Supporting Document</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="text-yellow-500 mr-3">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div>
                                        <p class="text-yellow-800 font-medium">No supporting document uploaded</p>
                                        <p class="text-yellow-700 text-sm mt-1">
                                            This loan application does not have a supporting document attached.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Member Account Status -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Account Status</h2>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-green-800">Savings
                                Balance</label>
                            <p class="text-2xl font-bold text-green-700 mt-1">KES
                                <?php echo e(number_format($loan->user->savings->available_savings ?? 0, 2)); ?>

                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-blue-800">Loan
                                Eligibility</label>
                            <p class="text-2xl font-bold text-blue-700 mt-1">KES
                                <?php echo e(number_format($loan->user->loan_eligibility ?? 0, 2)); ?>

                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-purple-800">Active
                                Loans</label>
                            <p class="text-2xl font-bold text-purple-700 mt-1">
                                <?php echo e($loan->user->loans()->whereIn('status', ['active', 'disbursed'])->count()); ?>

                            </p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-sm text-amber-900">
                            <strong>Requested Amount vs Eligibility:</strong>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->amount <= ($loan->user->loan_eligibility ?? 0)): ?>
                                <span class="text-green-700">✓ Member is eligible for requested amount</span>
                            <?php else: ?>
                                <span class="text-red-700">✗ Requested amount exceeds eligibility by KES
                                    <?php echo e(number_format($loan->amount - ($loan->user->loan_eligibility ?? 0), 2)); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Approval Form -->
            <div class="lg:col-span-1">

                <!-- Approval Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900">Decision</h2>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'pending'): ?>
                        <!-- Approve Form -->
                        <form action="<?php echo e(route('chairman.loans.approve', $loan->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-700 font-medium mb-2">Additional Notes (Optional)</label>
                                <textarea name="notes"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    rows="3" placeholder="Add any notes for the member..."></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold transition">
                                ✓ Approve Loan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="<?php echo e(route('chairman.loans.reject', $loan->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-700 font-medium mb-2">Rejection Reason</label>
                                <textarea name="rejection_reason"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                    rows="3" placeholder="Explain why this loan is being rejected..." required></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition"
                                onclick="return confirm('Are you sure you want to reject this loan?');">
                                ✗ Reject Loan
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="font-medium text-gray-800">This loan has been <?php echo e(ucfirst($loan->status)); ?>.</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->approver): ?>
                                <p class="text-sm text-gray-600 mt-2">Approved/Processed by:
                                    <strong><?php echo e($loan->approver->name); ?></strong> (<?php echo e(ucfirst($loan->approver->role)); ?>)</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->rejection_reason): ?>
                                <p class="text-sm text-red-600 mt-2">Rejection reason: <?php echo e($loan->rejection_reason); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Decision Info -->
                    <div class="mt-6 pt-6 border-t">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            <strong>Note:</strong> Once you approve or reject this loan, the member will be notified.
                            Approved loans will be marked for treasurer disbursement.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/chairman/loan-approval-detail.blade.php ENDPATH**/ ?>