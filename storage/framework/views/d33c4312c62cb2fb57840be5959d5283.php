


<?php $__env->startSection('title', 'Documents'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Documents</h1>
        <p class="text-gray-500 mt-2">Browse all SACCO-related documents available to your account.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Document Card 1 -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5 flex flex-col">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gray-100 flex items-center justify-center rounded-lg">
                    <span class="text-2xl">📄</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Loan Policy Document</h3>
                    <p class="text-gray-500 text-sm">PDF · Updated Jan 2025</p>
                </div>
            </div>
            <p class="text-gray-600 mt-4 text-sm">
                Contains the full SACCO loan procedures, qualification requirements, and approval workflow.
            </p>
            <div class="mt-auto pt-4">
                <button class="w-full text-center py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    View / Download
                </button>
            </div>
        </div>

        <!-- Document Card 2 -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5 flex flex-col">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 flex items-center justify-center rounded-lg">
                    <span class="text-2xl">💰</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Savings Guide</h3>
                    <p class="text-gray-500 text-sm">PDF · Updated Feb 2025</p>
                </div>
            </div>
            <p class="text-gray-600 mt-4 text-sm">
                Complete guide on savings products, interest rates, and withdrawal procedures.
            </p>
            <div class="mt-auto pt-4">
                <button class="w-full text-center py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    View / Download
                </button>
            </div>
        </div>

        <!-- Document Card 3 -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5 flex flex-col">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 flex items-center justify-center rounded-lg">
                    <span class="text-2xl">📊</span>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">Annual Report 2024</h3>
                    <p class="text-gray-500 text-sm">PDF · Updated Mar 2025</p>
                </div>
            </div>
            <p class="text-gray-600 mt-4 text-sm">
                Financial statements, performance metrics, and strategic outlook for 2024.
            </p>
            <div class="mt-auto pt-4">
                <button class="w-full text-center py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    View / Download
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/documents/index.blade.php ENDPATH**/ ?>