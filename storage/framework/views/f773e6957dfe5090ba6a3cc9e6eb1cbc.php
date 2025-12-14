

<?php $__env->startSection('title', 'Loan Approvals'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Pending Loan Approvals</h1>
                    <p class="text-gray-500 mt-1">Review and approve member loan applications</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Pending</p>
                    <p class="text-3xl font-bold text-yellow-600"><?php echo e($loans->total()); ?></p>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loans->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse" style="border:1px solid #e5e7eb;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">#</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Member</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Loan Number
                                </th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Amount</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Purpose</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Applied Date
                                </th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border border-gray-200 text-gray-700">
                                        <?php echo e($loans->firstItem() + $loop->index); ?></td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900"><?php echo e($loan->user->name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($loan->user->employee_number); ?></p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200 font-mono text-gray-900"><?php echo e($loan->loan_number); ?>

                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">KES <?php echo e(number_format($loan->amount, 2)); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($loan->period_months); ?> months</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200 text-gray-700"><?php echo e($loan->purpose ?? 'General'); ?>

                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="text-gray-900"><?php echo e($loan->applied_date->format('d M Y')); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($loan->applied_date->diffForHumans()); ?></p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="<?php echo e(route('secretary.loan-approval-detail', $loan->id)); ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition">Review →</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($loans->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <div class="text-5xl mb-4">✅</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Pending Loans</h3>
                    <p class="text-gray-500">All loan applications have been reviewed.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/loan-approvals.blade.php ENDPATH**/ ?>