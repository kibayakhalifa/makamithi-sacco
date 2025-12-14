

<?php $__env->startSection('title', 'Financial Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 font-sans text-gray-900">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">Financial Reports</h1>
                <p class="text-sm text-gray-500 mt-1">Generate, view and export SACCO financial reports</p>
            </div>

            <div class="text-left md:text-right">
                <p class="text-xs text-gray-500">Reporting Period</p>
                <p class="text-lg md:text-2xl font-semibold"><?php echo e(now()->format('F Y')); ?></p>
            </div>
        </div>
    </div>

    <!-- Cards (simplified, monochrome) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['title'=>'Statement of Financial Position','value'=>'KES 12.4M','sub'=>'Total Assets','id'=>'financial-position'],
            ['title'=>'Savings Summary','value'=>'KES 8.24M','sub'=>'156 members','id'=>'savings-summary'],
            ['title'=>'Loan Balances','value'=>'KES 4.21M','sub'=>'89 active loans','id'=>'loan-balances'],
            ['title'=>'Reconciliation','value'=>'KES 12.4M','sub'=>'Bank vs System','id'=>'reconciliation'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-medium text-gray-600 uppercase tracking-wide"><?php echo e($card['title']); ?></h3>
                    <p class="text-xl font-semibold mt-2"><?php echo e($card['value']); ?></p>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($card['sub']); ?></p>
                </div>

                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M5 21h14" />
                    </svg>
                </div>
            </div>

            <button
                onclick="generateReport('<?php echo e($card['id']); ?>')"
                class="mt-4 w-full bg-gray-900 hover:bg-gray-800 text-white py-2 rounded-lg text-sm font-medium transition"
            >
                Generate Report
            </button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Filters (compact) -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-800">Custom Report</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-3">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Report Type</label>
                <select id="reportType" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <option value="financial-position">Statement of Financial Position</option>
                    <option value="savings-summary">Savings Summary</option>
                    <option value="loan-balances">Loan Balances</option>
                    <option value="reconciliation">Bank Reconciliation</option>
                    <option value="expenses">Expenses Report</option>
                    <option value="members">Members Report</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Start Date</label>
                <input type="date" id="startDate" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">End Date</label>
                <input type="date" id="endDate" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Format</label>
                <select id="reportFormat" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="csv">CSV</option>
                    <option value="html">Web</option>
                </select>
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <button onclick="resetFilters()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md text-sm">Reset</button>
            <button onclick="generateCustomReport()" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-md text-sm">Generate</button>
        </div>
    </div>

    <!-- Preview -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-gray-800">Report Preview</h3>

            <div class="flex items-center gap-2">
                <button onclick="printReport()" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm">Print</button>
                <button onclick="exportReport()" class="px-3 py-1 bg-gray-900 hover:bg-gray-800 text-white rounded text-sm">Export</button>
            </div>
        </div>

        <div id="reportPreview" class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-xs font-medium text-gray-600 uppercase">Description</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-600 uppercase">Amount (KES)</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-600 uppercase">Change</th>
                        <th class="px-4 py-2 text-xs font-medium text-gray-600 uppercase">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-2 font-semibold text-gray-800">ASSETS</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Cash at Bank</td>
                        <td class="px-4 py-3 font-semibold">12,450,000.00</td>
                        <td class="px-4 py-3 text-gray-600">+450,000.00</td>
                        <td class="px-4 py-3 text-gray-500">Equity Bank A/C</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Loan Receivables</td>
                        <td class="px-4 py-3 font-semibold">4,210,000.00</td>
                        <td class="px-4 py-3 text-gray-600">+210,000.00</td>
                        <td class="px-4 py-3 text-gray-500">89 active loans</td>
                    </tr>

                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-2 font-semibold text-gray-800">LIABILITIES</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Members' Savings</td>
                        <td class="px-4 py-3 font-semibold">8,240,000.00</td>
                        <td class="px-4 py-3 text-gray-600">+240,000.00</td>
                        <td class="px-4 py-3 text-gray-500">156 members</td>
                    </tr>

                    <tr class="bg-gray-100">
                        <td class="px-4 py-3 font-semibold">TOTAL ASSETS</td>
                        <td class="px-4 py-3 font-semibold">16,685,000.00</td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-gray-50 p-3 rounded">
                <p class="text-xs text-gray-600">Report Generated</p>
                <p class="text-sm font-semibold"><?php echo e(now()->format('d M Y, h:i A')); ?></p>
            </div>
            <div class="bg-gray-50 p-3 rounded">
                <p class="text-xs text-gray-600">Period Covered</p>
                <p class="text-sm font-semibold">1 Jan - <?php echo e(now()->format('d M Y')); ?></p>
            </div>
            <div class="bg-gray-50 p-3 rounded">
                <p class="text-xs text-gray-600">Generated By</p>
                <p class="text-sm font-semibold"><?php echo e(auth()->user()->name); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Reports (compact) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-800 mb-2">Monthly Performance</h4>

            <div class="space-y-3 text-sm text-gray-600">
                <div>
                    <div class="flex justify-between mb-1">
                        <span>Savings Growth</span>
                        <span class="font-semibold">+12%</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gray-700 rounded-full" style="width:65%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span>Loan Portfolio</span>
                        <span class="font-semibold">+8%</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gray-700 rounded-full" style="width:45%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <span>Member Growth</span>
                        <span class="font-semibold">+5%</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gray-700 rounded-full" style="width:30%"></div>
                    </div>
                </div>
            </div>

            <button onclick="generatePerformanceReport()" class="mt-4 w-full bg-gray-900 hover:bg-gray-800 text-white py-2 rounded text-sm">Generate Performance</button>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-800 mb-2">Quick Reports</h4>

            <div class="space-y-2">
                <button onclick="generateMemberStatement()" class="w-full text-left px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm">Member Statement</button>
                <button onclick="generateLoanArrears()" class="w-full text-left px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm">Loan Arrears</button>
                <button onclick="generateYearEnd()" class="w-full text-left px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm">Year-End Bonus</button>
                <button onclick="generateAuditTrail()" class="w-full text-left px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm">Audit Trail</button>
            </div>
        </div>
    </div>

</div>

<!-- Modal (simple) -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 items-center justify-center">
    <div class="bg-white rounded-lg p-4 w-full max-w-md shadow-lg">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 id="reportModalTitle" class="text-lg font-semibold text-gray-800">Generating</h3>
                <p id="reportModalMessage" class="text-sm text-gray-600 mt-1">Please wait...</p>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-3">
                    <div id="reportProgress" class="h-2 rounded-full bg-gray-700" style="width:0%"></div>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2">
                <button onclick="closeReportModal()" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Cancel</button>
                <button id="downloadBtn" onclick="downloadReport()" class="px-3 py-1 text-sm bg-gray-900 hover:bg-gray-800 text-white rounded hidden">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safe init for date fields
    const today = new Date().toISOString().split('T')[0];
    const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];

    const startEl = document.getElementById('startDate');
    const endEl = document.getElementById('endDate');

    if (startEl) { startEl.value = firstDay; startEl.max = today; }
    if (endEl) { endEl.value = today; endEl.max = today; }

    // Close modal by clicking backdrop
    const modal = document.getElementById('reportModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeReportModal();
        });
    }
});

function showReportModal(message) {
    const modal = document.getElementById('reportModal');
    if (!modal) return;
    const title = document.getElementById('reportModalTitle');
    const msg = document.getElementById('reportModalMessage');
    const progress = document.getElementById('reportProgress');
    const downloadBtn = document.getElementById('downloadBtn');

    if (title) title.textContent = 'Generating Report';
    if (msg) msg.textContent = message || 'Please wait while we generate your report...';
    if (progress) progress.style.width = '0%';
    if (downloadBtn) downloadBtn.classList.add('hidden');

    modal.classList.remove('hidden');
}

function closeReportModal() {
    const modal = document.getElementById('reportModal');
    if (!modal) return;
    modal.classList.add('hidden');
}

function simulateProgress(onComplete) {
    const progress = document.getElementById('reportProgress');
    if (!progress) { if (typeof onComplete === 'function') onComplete(); return; }

    let p = 0;
    const interval = setInterval(() => {
        p += Math.floor(Math.random() * 15) + 5;
        if (p >= 100) p = 100;
        progress.style.width = p + '%';
        if (p >= 100) {
            clearInterval(interval);
            if (typeof onComplete === 'function') onComplete();
        }
    }, 180);
}

/* High-level actions */
function generateReport(type) {
    const map = {
        'financial-position': 'Statement of Financial Position',
        'savings-summary': 'Savings Summary',
        'loan-balances': 'Loan Balances',
        'reconciliation': 'Bank Reconciliation'
    };
    showReportModal(`Generating ${map[type] || 'Report'}...`);
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = 'Report generated successfully.';
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function generateCustomReport() {
    const reportTypeEl = document.getElementById('reportType');
    const startEl = document.getElementById('startDate');
    const endEl = document.getElementById('endDate');
    const formatEl = document.getElementById('reportFormat');

    if (!reportTypeEl || !startEl || !endEl || !formatEl) { alert('Missing inputs'); return; }

    const start = startEl.value;
    const end = endEl.value;
    if (!start || !end) { alert('Please choose start and end dates'); return; }
    if (new Date(start) > new Date(end)) { alert('Start date cannot be after end date'); return; }

    const typeName = reportTypeEl.options[reportTypeEl.selectedIndex].text;
    showReportModal(`Generating ${typeName} (${start} → ${end}) in ${formatEl.value.toUpperCase()}...`);
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = `Report generated for ${start} to ${end}.`;
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function downloadReport() {
    const formatEl = document.getElementById('reportFormat');
    const typeEl = document.getElementById('reportType');
    const format = formatEl ? formatEl.value : 'pdf';
    const type = typeEl ? typeEl.value : 'report';
    const file = `${type}_${new Date().toISOString().split('T')[0]}.${format === 'excel' ? 'xlsx' : format}`;
    alert(`Downloading ${file}`);
    closeReportModal();
}

function resetFilters() {
    const today = new Date().toISOString().split('T')[0];
    const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    const startEl = document.getElementById('startDate');
    const endEl = document.getElementById('endDate');
    const typeEl = document.getElementById('reportType');
    const fmtEl = document.getElementById('reportFormat');

    if (startEl) startEl.value = firstDay;
    if (endEl) endEl.value = today;
    if (typeEl) typeEl.selectedIndex = 0;
    if (fmtEl) fmtEl.selectedIndex = 0;
}

function printReport() {
    window.print();
}

function exportReport() {
    alert('Exporting current view to PDF (placeholder)');
}

/* Quick report helpers */
function generatePerformanceReport() {
    showReportModal('Generating Performance Report...');
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = 'Performance report ready.';
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function generateMemberStatement() {
    const id = prompt('Member ID (e.g., EMP001):');
    if (!id) return;
    showReportModal(`Generating statement for ${id}...`);
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = `Statement for ${id} generated.`;
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function generateLoanArrears() {
    showReportModal('Generating Loan Arrears...');
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = 'Arrears report ready.';
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function generateYearEnd() {
    showReportModal('Calculating Year-End...');
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = 'Year-end calculations complete.';
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}

function generateAuditTrail() {
    showReportModal('Generating Audit Trail...');
    simulateProgress(() => {
        const msg = document.getElementById('reportModalMessage');
        if (msg) msg.textContent = 'Audit trail ready.';
        const dl = document.getElementById('downloadBtn');
        if (dl) dl.classList.remove('hidden');
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/reports/index.blade.php ENDPATH**/ ?>