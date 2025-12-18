

<?php $__env->startSection('title', 'Documents'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">📁</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Documents</h1>
                        <p class="text-gray-500 text-sm md:text-base">Access documents shared with you</p>
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                You have access to <?php echo e($documents->total()); ?> documents
            </div>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Documents Available to You</h3>
                    <p class="text-gray-500 text-sm">Documents shared by the Secretary</p>
                </div>
                <div class="flex gap-2">
                    <input type="text" placeholder="Search documents..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm w-full md:w-auto"
                        id="searchInput">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm"
                        id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="minutes">Meeting Minutes</option>
                        <option value="loans">Loan Documents</option>
                        <option value="members">Member Files</option>
                        <option value="financial">Financial Reports</option>
                        <option value="policy">Policies</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documents->isEmpty()): ?>
            <div class="text-center py-12 border border-dashed border-gray-300 rounded-lg">
                <div class="text-4xl mb-4">📁</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No documents available</h3>
                <p class="text-gray-500">No documents have been shared with you yet.</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Document
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Category
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Size
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Uploaded
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Uploader
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Access
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 border border-gray-300">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                                         style="background-color: <?php echo e([
                                             'minutes' => '#dcfce7',
                                             'loans' => '#fef3c7',
                                             'members' => '#e0e7ff',
                                             'financial' => '#fce7f3',
                                             'policy' => '#fef3c7',
                                             'other' => '#f3f4f6'
                                         ][$document->category] ?? '#f3f4f6'); ?>">
                                        <span style="color: <?php echo e([
                                            'minutes' => '#16a34a',
                                            'loans' => '#d97706',
                                            'members' => '#4f46e5',
                                            'financial' => '#db2777',
                                            'policy' => '#d97706',
                                            'other' => '#6b7280'
                                        ][$document->category] ?? '#6b7280'); ?>">
                                            <?php echo e([
                                                'minutes' => '📝',
                                                'loans' => '📄',
                                                'members' => '👤',
                                                'financial' => '💰',
                                                'policy' => '📋',
                                                'other' => '📎'
                                            ][$document->category] ?? '📁'); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm"><?php echo e($document->title); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($document->file_name); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200 capitalize">
                                    <?php echo e(str_replace('_', ' ', $document->category)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                <?php echo e(formatFileSize($document->file_size)); ?>

                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 border border-gray-300">
                                <?php echo e($document->created_at->diffForHumans()); ?>

                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                                <?php echo e($document->uploader->name ?? 'Unknown'); ?>

                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document->is_public): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    Public
                                </span>
                                <?php elseif($document->access_type === 'committee'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Committee
                                </span>
                                <?php elseif($document->access_type === 'members'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                    All Members
                                </span>
                                <?php elseif($document->access_type === 'specific_users'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                    Specific Users
                                </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('documents.download', $document)); ?>"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                <?php echo e($documents->links()); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<?php
function formatFileSize($bytes) {
    if ($bytes == 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>

<script>
    // Search and filter functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    document.getElementById('categoryFilter').addEventListener('change', function(e) {
        const category = e.target.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (!category) {
                row.style.display = '';
                return;
            }
            
            const categoryCell = row.querySelector('td:nth-child(2) span');
            if (categoryCell && categoryCell.textContent.toLowerCase().includes(category)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/documents/index.blade.php ENDPATH**/ ?>