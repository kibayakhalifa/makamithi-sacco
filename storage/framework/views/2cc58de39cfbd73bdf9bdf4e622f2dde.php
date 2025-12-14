

<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Notifications</h1>
                <p class="text-gray-500 text-sm md:text-base mt-1">
                    Stay updated with SACCO announcements and communications
                </p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role !== 'member'): ?>
            <a href="<?php echo e(route('communications.create')); ?>"
                class="px-6 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition flex items-center gap-2">
                <span>✉️</span> New Notification
            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">All Communications</h3>
                <p class="text-gray-500 text-sm">Recent announcements and notifications</p>
            </div>
            <div class="text-sm text-gray-500">
                <?php echo e($communications->count()); ?> notifications
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($communications->count() > 0): ?>
        <div class="overflow-x-auto border border-gray-300 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            #
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            Title
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            Preview
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            Posted By
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            Date Posted
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $communications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                            <?php echo e($index + 1); ?>

                        </td>
                        <td class="px-4 py-3 border border-gray-300">
                            <a href="<?php echo e(route('communications.show', $comm->id)); ?>" class="font-semibold text-gray-900 hover:text-blue-600 transition">
                                <?php echo e($comm->title); ?>

                            </a>
                        </td>
                        <td class="px-4 py-3 border border-gray-300">
                            <p class="text-gray-600 text-sm"><?php echo e(Str::limit($comm->body, 80)); ?></p>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-gray-700 text-sm font-medium">
                                        <?php echo e(strtoupper(substr($comm->creator->name ?? 'System', 0, 1))); ?>

                                    </span>
                                </div>
                                <?php echo e($comm->creator->name ?? 'System'); ?>

                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                            <div>
                                <p><?php echo e($comm->created_at->format('d M Y')); ?></p>
                                <p class="text-xs"><?php echo e($comm->created_at->format('h:i A')); ?></p>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                            <a href="<?php echo e(route('communications.show', $comm->id)); ?>"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium transition">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-12 border border-gray-300 rounded-lg">
            <div class="text-4xl mb-4">📭</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Communications Yet</h3>
            <p class="text-gray-500">There are no notifications at the moment.</p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role !== 'member'): ?>
            <a href="<?php echo e(route('communications.create')); ?>" class="mt-4 inline-block px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                Create First Notification
            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/communications/index.blade.php ENDPATH**/ ?>