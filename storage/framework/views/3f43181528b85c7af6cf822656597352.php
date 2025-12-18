<?php $__env->startSection('title', 'My Loans'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">My Loans</h1>
                    <p class="text-gray-500 mt-1">Manage and track your loan applications</p>
                </div>
                <a href="<?php echo e(route('member.loans.apply')); ?>"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    + Apply New Loan
                </a>
            </div>
        </div>

        <!-- Loan Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
                $user = auth()->user();
                $activeLoansCount = $loans->whereIn('status', ['active', 'disbursed', 'approved'])->count();
                
                // Query first loan directly
                $firstLoan = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->where('loan_type', 'first_loan')
                    ->first();
                
                // Query second loan directly
                $secondLoan = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->where('loan_type', 'second_loan')
                    ->first();
                
                $canApplySecond = $firstLoan && $firstLoan->percentage_paid >= 50 && !$secondLoan;
            ?>

            <div class="bg-blue-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Loans</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($loans->count()); ?></p>
                    </div>
                    <div class="text-3xl">📋</div>
                </div>
            </div>
            
            <div class="bg-green-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Active Loans</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($activeLoansCount); ?></p>
                        <div class="text-xs text-gray-500 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstLoan): ?> 1st Loan: <?php echo e(number_format($firstLoan->percentage_paid, 1)); ?>% <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondLoan): ?> | 2nd Loan <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
            </div>
            
            <div class="bg-purple-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Eligible Amount</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">KES <?php echo e(number_format($eligibility, 0)); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canApplySecond): ?>
                            <div class="text-xs text-green-600 mt-1">✓ Eligible for Second Loan</div>
                        <?php elseif($firstLoan && $firstLoan->percentage_paid < 50): ?>
                            <div class="text-xs text-yellow-600 mt-1"><?php echo e(number_format(50 - $firstLoan->percentage_paid, 1)); ?>% to qualify for 2nd loan</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>
        </div>

        <!-- Quick Status -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstLoan || $secondLoan): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstLoan): ?>
            <div class="bg-white border border-blue-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-lg">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">First Loan</h3>
                            <p class="text-sm text-gray-600"><?php echo e($firstLoan->loan_number); ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold <?php echo e($firstLoan->percentage_paid >= 50 ? 'text-green-600' : 'text-yellow-600'); ?>">
                            <?php echo e(number_format($firstLoan->percentage_paid, 1)); ?>% Paid
                        </p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstLoan->percentage_paid >= 50 && !$secondLoan): ?>
                            <a href="<?php echo e(route('member.loans.apply')); ?>" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                ✓ Apply for Second Loan
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(min($firstLoan->percentage_paid, 100)); ?>%"></div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondLoan): ?>
            <div class="bg-white border border-green-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-600 text-lg">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Second Loan</h3>
                            <p class="text-sm text-gray-600"><?php echo e($secondLoan->loan_number); ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">
                            <?php echo e(number_format($secondLoan->percentage_paid, 1)); ?>% Paid
                        </p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e(min($secondLoan->percentage_paid, 100)); ?>%"></div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Loans Table -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">All Loans</h2>
                <p class="text-sm text-gray-500 mt-1">Your loan history including first and second loans</p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loans->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-gray-50">
                            <tr class="border border-gray-300">
                                <th class="px-4 py-3 text-center border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Loan ID</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Loan Applied (KES)</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Application Date</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Period (Months)</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Interest Rate</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Repayable Amount (KES)</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Monthly Payment (KES)</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Expected Date</th>
                                <th class="px-4 py-3 text-left border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center border border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border border-gray-300 hover:bg-gray-50">
                                    <!-- Row Number -->
                                    <td class="px-4 py-3 text-center border border-gray-300 text-gray-500">
                                        <?php echo e($loop->iteration); ?>

                                    </td>

                                    <!-- Loan ID -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="font-medium text-gray-900"><?php echo e($loan->loan_number); ?></div>
                                    </td>

                                    <!-- Loan Applied (KES) -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900 font-medium">
                                            <?php echo e(number_format($loan->amount, 0)); ?>

                                        </div>
                                    </td>

                                    <!-- Application Date -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900"><?php echo e($loan->applied_date->format('d/m/Y')); ?></div>
                                    </td>

                                    <!-- Period (Months) -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900"><?php echo e($loan->period_months); ?></div>
                                    </td>

                                    <!-- Interest Rate -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900"><?php echo e(number_format($loan->interest_rate, 1)); ?>%</div>
                                    </td>

                                    <!-- Repayable Amount (KES) -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900 font-medium">
                                            <?php echo e(number_format($loan->total_repayable, 0)); ?>

                                        </div>
                                    </td>

                                    <!-- Monthly Payment (KES) -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900 font-medium">
                                            <?php echo e(number_format($loan->monthly_payment, 0)); ?>

                                        </div>
                                    </td>

                                    <!-- Expected Date -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-900"><?php echo e($loan->expected_completion_date?->format('d/m/Y') ?? 'N/A'); ?></div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-4 py-3 border border-gray-300">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'pending'): ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-300 rounded">
                                                Pending
                                            </span>
                                        <?php elseif($loan->status === 'approved'): ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 border border-blue-300 rounded">
                                                Approved
                                            </span>
                                        <?php elseif($loan->status === 'rejected'): ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 border border-red-300 rounded">
                                                Rejected
                                            </span>
                                        <?php elseif($loan->status === 'disbursed' || $loan->status === 'active'): ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-300 rounded">
                                                Active
                                            </span>
                                        <?php elseif($loan->status === 'completed'): ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 border border-gray-300 rounded">
                                                Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 border border-gray-300 rounded">
                                                <?php echo e(ucfirst($loan->status)); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <!-- Action -->
                                    <td class="px-4 py-3 text-center border border-gray-300">
                                        <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>" 
                                           class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-300 rounded hover:bg-blue-100 transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-300 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <?php echo e($loans->firstItem()); ?> to <?php echo e($loans->lastItem()); ?> of <?php echo e($loans->total()); ?> results
                        </div>
                        <div>
                            <?php echo e($loans->links()); ?>

                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <div class="text-5xl mb-4">📋</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Loans Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't applied for any loans yet.</p>
                    <a href="<?php echo e(route('member.loans.apply')); ?>"
                        class="inline-block px-6 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for Your First Loan
                    </a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/index.blade.php ENDPATH**/ ?>