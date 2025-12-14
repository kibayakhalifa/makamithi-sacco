

<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-2xl p-6 border border-indigo-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Reports & Statements</h1>
                    <p class="text-indigo-800 mt-2">Generate and download your account statements and reports</p>
                </div>
            </div>
        </div>

        <!-- Available Reports -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Available Reports</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-indigo-300 transition cursor-pointer"
                        onclick="openReportModal('<?php echo e($report['id']); ?>', '<?php echo e($report['name']); ?>')">
                        <div class="flex items-start justify-between mb-3">
                            <span class="text-4xl"><?php echo e($report['icon']); ?></span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2"><?php echo e($report['name']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo e($report['description']); ?></p>
                        <div class="flex flex-wrap gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $report['formats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded"><?php echo e(strtoupper($format)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Generate Report Form Modal -->
        <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
                <div class="p-6 border-b sticky top-0 bg-white">
                    <h2 class="text-xl font-bold text-gray-900" id="modalTitle">Generate Report</h2>
                    <p class="text-gray-600 text-sm mt-1">Select date range and format</p>
                </div>

                <form action="<?php echo e(route('member.reports.generate')); ?>" method="POST" class="p-6 space-y-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="report_type" id="reportType">

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Start Date</label>
                        <input type="date" name="start_date" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            value="<?php echo e(now()->subMonths(6)->toDateString()); ?>">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">End Date</label>
                        <input type="date" name="end_date" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            value="<?php echo e(now()->toDateString()); ?>">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Format</label>
                        <select name="format" required id="formatSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Select format</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                            <option value="print">Print</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Reports -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentReports && $recentReports->count() > 0): ?>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recently Generated Reports</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-300 bg-gray-50">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Report Type
                                </th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date Range
                                </th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Format</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Generated
                                </th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300"><?php echo e($index + 1); ?></td>
                                    <td class="px-6 py-4 text-gray-900 border-r border-gray-300"><?php echo e($report->report_type); ?></td>
                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                        <?php echo e($report->start_date->format('d M Y')); ?> - <?php echo e($report->end_date->format('d M Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded font-medium">
                                            <?php echo e(strtoupper($report->format)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                        <?php echo e($report->created_at->format('d M Y, H:i')); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('member.reports.download', $report->id)); ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                            Download →
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    <script>
        const reportModal = document.getElementById('reportModal');
        const reportTypes = <?php echo json_encode($reportTypes, 15, 512) ?>;

        function openReportModal(reportId, reportName) {
            document.getElementById('reportType').value = reportId;
            document.getElementById('modalTitle').textContent = 'Generate ' + reportName;

            // Filter available formats for this report
            const report = reportTypes.find(r => r.id === reportId);
            const formatSelect = document.getElementById('formatSelect');
            const currentValue = formatSelect.value;

            // Reset and populate formats
            formatSelect.innerHTML = '<option value="">Select format</option>';
            report.formats.forEach(format => {
                const option = document.createElement('option');
                option.value = format;
                option.textContent = format.charAt(0).toUpperCase() + format.slice(1);
                formatSelect.appendChild(option);
            });

            reportModal.classList.remove('hidden');
        }

        // Close modal when clicking outside
        reportModal.addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/reports/index.blade.php ENDPATH**/ ?>