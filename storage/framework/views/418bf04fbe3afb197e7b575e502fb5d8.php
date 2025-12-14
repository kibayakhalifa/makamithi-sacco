

<?php $__env->startSection('title', 'Financial Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 font-sans">

    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <span class="text-orange-700 font-bold text-lg">7</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Financial Reports</h1>
                </div>
                <p class="text-orange-800">Generate, view, and export comprehensive financial reports</p>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-orange-600 text-sm font-medium">Reporting Period</p>
                    <p class="text-4xl font-bold text-gray-900"><?php echo e(date('F Y')); ?></p>
                    <p class="text-gray-500 text-xs mt-1"><?php echo e($startDate); ?> to <?php echo e($endDate); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['title' => 'Statement of Financial Position', 'value' => 'KES 16.8M', 'sub' => 'Total Assets', 'icon' => '📊', 'color' => 'green'],
            ['title' => 'Income Statement', 'value' => 'KES 2.4M', 'sub' => 'Net Income', 'icon' => '📈', 'color' => 'blue'],
            ['title' => 'Cash Flow Statement', 'value' => 'KES 850K', 'sub' => 'Net Cash Flow', 'icon' => '💰', 'color' => 'purple'],
            ['title' => 'Member Reports', 'value' => '156', 'sub' => 'Active Members', 'icon' => '👥', 'color' => 'orange'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium"><?php echo e($card['title']); ?></h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($card['value']); ?></p>
                    <p class="text-gray-500 text-sm mt-1"><?php echo e($card['sub']); ?></p>
                </div>
                <div class="bg-<?php echo e($card['color']); ?>-50 p-3 rounded-xl">
                    <span class="text-<?php echo e($card['color']); ?>-600 text-xl"><?php echo e($card['icon']); ?></span>
                </div>
            </div>
            
            <button onclick="generateReport('<?php echo e(strtolower(str_replace(' ', '-', $card['title']))); ?>')" 
                    class="mt-4 w-full bg-gray-900 hover:bg-black text-white py-2 rounded-lg text-sm font-medium">
                Generate Report
            </button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Report Generator -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Custom Report Generator</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                <select id="reportType" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" id="startDate" value="<?php echo e($startDate); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" id="endDate" value="<?php echo e($endDate); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                <select id="reportFormat" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="pdf">PDF Document</option>
                    <option value="excel">Excel Spreadsheet</option>
                    <option value="csv">CSV File</option>
                    <option value="html">Web View</option>
                </select>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button onclick="generateCustomReport()" 
                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium">
                Generate Report
            </button>
            <button onclick="previewReport()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium">
                Preview
            </button>
            <button onclick="resetFilters()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium">
                Reset
            </button>
        </div>
    </div>

    <!-- Report Preview -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900">Report Preview</h3>
            <div class="flex gap-2">
                <button onclick="printReport()" 
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                    Print
                </button>
                <button onclick="exportReport()" 
                        class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Export
                </button>
            </div>
        </div>
        
        <!-- Report Content -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Amount (KES)</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Change</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Assets Section -->
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-3 font-semibold text-gray-900">ASSETS</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Cash at Bank</td>
                        <td class="px-4 py-3 font-semibold">12,450,000.00</td>
                        <td class="px-4 py-3 text-green-600">+450,000.00</td>
                        <td class="px-4 py-3 text-gray-500">Equity Bank A/C</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Loan Receivables</td>
                        <td class="px-4 py-3 font-semibold">4,210,000.00</td>
                        <td class="px-4 py-3 text-green-600">+210,000.00</td>
                        <td class="px-4 py-3 text-gray-500">89 active loans</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Accrued Interest</td>
                        <td class="px-4 py-3 font-semibold">85,000.00</td>
                        <td class="px-4 py-3 text-green-600">+5,000.00</td>
                        <td class="px-4 py-3 text-gray-500">Monthly accrual</td>
                    </tr>
                    
                    <!-- Liabilities Section -->
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-3 font-semibold text-gray-900">LIABILITIES</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Members' Savings</td>
                        <td class="px-4 py-3 font-semibold">8,240,000.00</td>
                        <td class="px-4 py-3 text-green-600">+240,000.00</td>
                        <td class="px-4 py-3 text-gray-500">156 members</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Accrued Dividends</td>
                        <td class="px-4 py-3 font-semibold">45,000.00</td>
                        <td class="px-4 py-3 text-green-600">+5,000.00</td>
                        <td class="px-4 py-3 text-gray-500">Year-end payment</td>
                    </tr>
                    
                    <!-- Equity Section -->
                    <tr class="bg-gray-50">
                        <td colspan="4" class="px-4 py-3 font-semibold text-gray-900">EQUITY</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Share Capital</td>
                        <td class="px-4 py-3 font-semibold">5,000,000.00</td>
                        <td class="px-4 py-3">0.00</td>
                        <td class="px-4 py-3 text-gray-500">Fixed capital</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Retained Earnings</td>
                        <td class="px-4 py-3 font-semibold">1,200,000.00</td>
                        <td class="px-4 py-3 text-green-600">+200,000.00</td>
                        <td class="px-4 py-3 text-gray-500">From operations</td>
                    </tr>
                    
                    <!-- Totals -->
                    <tr class="bg-gray-100 font-semibold">
                        <td class="px-4 py-3">TOTAL ASSETS</td>
                        <td class="px-4 py-3">16,745,000.00</td>
                        <td class="px-4 py-3">+665,000.00</td>
                        <td class="px-4 py-3"></td>
                    </tr>
                    <tr class="bg-gray-100 font-semibold">
                        <td class="px-4 py-3">TOTAL LIABILITIES & EQUITY</td>
                        <td class="px-4 py-3">16,745,000.00</td>
                        <td class="px-4 py-3">+665,000.00</td>
                        <td class="px-4 py-3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Report Metadata -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-600 text-sm">Report Generated</p>
                <p class="text-sm font-semibold"><?php echo e(date('d M Y, h:i A')); ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-600 text-sm">Period Covered</p>
                <p class="text-sm font-semibold"><?php echo e($startDate); ?> to <?php echo e($endDate); ?></p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-600 text-sm">Generated By</p>
                <p class="text-sm font-semibold"><?php echo e(auth()->user()->name); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Reports</h3>
            <div class="space-y-3">
                <button onclick="generateMemberStatement()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>👤 Member Statement</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateLoanArrears()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>⚠️ Loan Arrears Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateYearEnd()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📅 Year-End Financials</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateAuditTrail()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>🔐 Audit Trail Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generatePerformance()" 
                        class="w-full text-left px-4 py-3 bg-orange-50 hover:bg-orange-100 text-orange-800 rounded-lg text-sm flex justify-between items-center">
                    <span>📈 Performance Dashboard</span>
                    <span class="text-orange-600">→</span>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Monthly Performance</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Savings Growth</span>
                        <span class="text-green-600 text-sm font-medium">+12%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Loan Portfolio Growth</span>
                        <span class="text-blue-600 text-sm font-medium">+8%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Member Growth</span>
                        <span class="text-orange-600 text-sm font-medium">+5%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Profit Margin</span>
                        <span class="text-purple-600 text-sm font-medium">65%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>
            
            <button onclick="generatePerformanceReport()" 
                    class="mt-6 w-full bg-gray-900 hover:bg-black text-white py-3 rounded-lg font-medium">
                Generate Performance Report
            </button>
        </div>
    </div>

</div>

<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1">
                <h3 id="reportModalTitle" class="text-lg font-semibold text-gray-800">Generating Report</h3>
                <p id="reportModalMessage" class="text-sm text-gray-600 mt-1">Please wait while we generate your report...</p>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-3">
                    <div id="reportProgress" class="h-2 rounded-full bg-orange-600" style="width:0%"></div>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-2">
                <button onclick="closeReportModal()" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Cancel</button>
                <button id="downloadBtn" onclick="downloadReport()" class="px-3 py-1 text-sm bg-orange-600 hover:bg-orange-700 text-white rounded hidden">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Report generation functions
function generateReport(reportType) {
    showReportModal(`Generating ${reportType.replace('-', ' ')} report...`);
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Report generated successfully!';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function generateCustomReport() {
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const format = document.getElementById('reportFormat').value;
    
    if (!startDate || !endDate) {
        alert('Please select start and end dates');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('Start date cannot be after end date');
        return;
    }
    
    const reportName = document.getElementById('reportType').options[document.getElementById('reportType').selectedIndex].text;
    showReportModal(`Generating ${reportName} (${startDate} to ${endDate})...`);
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = `Report generated for ${startDate} to ${endDate}`;
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function previewReport() {
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    // In a real app, this would load the preview via AJAX
    alert(`Previewing ${reportType} report for ${startDate} to ${endDate}`);
}

function resetFilters() {
    const today = new Date().toISOString().split('T')[0];
    const firstDay = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    
    document.getElementById('startDate').value = firstDay;
    document.getElementById('endDate').value = today;
    document.getElementById('reportType').selectedIndex = 0;
    document.getElementById('reportFormat').selectedIndex = 0;
}

function printReport() {
    window.print();
}

function exportReport() {
    const format = document.getElementById('reportFormat').value;
    const reportType = document.getElementById('reportType').value;
    
    alert(`Exporting report as ${format.toUpperCase()}...`);
}

// Quick report functions
function generateMemberStatement() {
    const memberId = prompt('Enter Member ID or Employee Number:');
    if (memberId) {
        showReportModal(`Generating statement for member ${memberId}...`);
        simulateProgress(() => {
            document.getElementById('reportModalMessage').textContent = `Statement for ${memberId} generated`;
            document.getElementById('downloadBtn').classList.remove('hidden');
        });
    }
}

function generateLoanArrears() {
    showReportModal('Generating loan arrears report...');
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Arrears report generated';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function generateYearEnd() {
    showReportModal('Generating year-end financial statements...');
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Year-end reports generated';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function generateAuditTrail() {
    showReportModal('Generating audit trail report...');
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Audit trail report generated';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function generatePerformance() {
    showReportModal('Generating performance dashboard...');
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Performance dashboard generated';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

function generatePerformanceReport() {
    showReportModal('Generating performance report...');
    simulateProgress(() => {
        document.getElementById('reportModalMessage').textContent = 'Performance report generated';
        document.getElementById('downloadBtn').classList.remove('hidden');
    });
}

// Modal functions
function showReportModal(message) {
    document.getElementById('reportModalTitle').textContent = 'Generating Report';
    document.getElementById('reportModalMessage').textContent = message;
    document.getElementById('reportProgress').style.width = '0%';
    document.getElementById('downloadBtn').classList.add('hidden');
    document.getElementById('reportModal').classList.remove('hidden');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
}

function simulateProgress(onComplete) {
    const progress = document.getElementById('reportProgress');
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

function downloadReport() {
    const format = document.getElementById('reportFormat').value;
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    const filename = `${reportType}_${startDate}_to_${endDate}.${format === 'excel' ? 'xlsx' : format}`;
    alert(`Downloading ${filename}...`);
    closeReportModal();
}

// Close modal when clicking outside
document.getElementById('reportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReportModal();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/financial-reports.blade.php ENDPATH**/ ?>