@extends('components.dashboard-layout')

@section('title', 'Bank Reconciliation')

@section('content')
<div class="space-y-6 font-sans">

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-green-700 font-bold text-lg">6</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Bank Reconciliation</h1>
                </div>
                <p class="text-green-800">Reconcile bank statements with system records and track differences</p>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-green-600 text-sm font-medium">Reconciliation Status</p>
                    <p class="text-4xl font-bold 
                        {{ $reconciliationStats['difference'] == 0 ? 'text-green-600' : 'text-orange-600' }}">
                        {{ $reconciliationStats['difference'] == 0 ? 'BALANCED' : 'UNBALANCED' }}
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Difference: KES {{ number_format(abs($reconciliationStats['difference']), 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reconciliation Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Bank Balance</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($reconciliationStats['bank_balance'], 2) }}</p>
                    <p class="text-gray-500 text-sm mt-1">From statement</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <span class="text-blue-600 text-xl">🏦</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">System Balance</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($reconciliationStats['system_balance'], 2) }}</p>
                    <p class="text-gray-500 text-sm mt-1">Calculated</p>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-xl">💻</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Difference</h3>
                    <p class="text-2xl font-bold {{ $reconciliationStats['difference'] == 0 ? 'text-green-600' : 'text-orange-600' }} mt-2">
                        {{ $reconciliationStats['difference'] >= 0 ? '+' : '' }}KES {{ number_format($reconciliationStats['difference'], 2) }}
                    </p>
                    <p class="text-gray-500 text-sm mt-1">
                        @if($reconciliationStats['difference'] > 0)
                        System has less
                        @elseif($reconciliationStats['difference'] < 0)
                        System has more
                        @else
                        Perfect match
                        @endif
                    </p>
                </div>
                <div class="{{ $reconciliationStats['difference'] == 0 ? 'bg-green-50' : 'bg-orange-50' }} p-3 rounded-xl">
                    <span class="{{ $reconciliationStats['difference'] == 0 ? 'text-green-600' : 'text-orange-600' }} text-xl">
                        {{ $reconciliationStats['difference'] == 0 ? '✅' : '⚠️' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Unreconciled</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $reconciliationStats['unreconciled_count'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Transactions</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-xl">
                    <span class="text-orange-600 text-xl">📋</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Reconciliation -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Run New Reconciliation</h3>
        
        <form id="reconciliationForm" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reconciliation Date</label>
                    <input type="date" id="reconciliation_date" name="reconciliation_date" 
                           value="{{ date('Y-m-d') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Statement Balance</label>
                    <input type="number" step="0.01" id="bank_statement_balance" name="bank_statement_balance" 
                           placeholder="0.00" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Statement File</label>
                    <input type="file" id="bank_statement_file" name="bank_statement_file" 
                           accept=".pdf,.csv,.xlsx"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea id="notes" name="notes" rows="2" 
                          placeholder="Any notes about this reconciliation..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="calculateDifference()" 
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium">
                    Calculate Difference
                </button>
                <button type="button" onclick="runReconciliation()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                    Run Reconciliation
                </button>
                <button type="button" onclick="uploadStatement()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    Upload Statement
                </button>
            </div>
        </form>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('unreconciled')" id="unreconciledTab" 
                        class="px-6 py-4 font-medium border-b-2 border-orange-600 text-orange-700 whitespace-nowrap">
                    📋 Unreconciled Transactions ({{ $unreconciledTransactions->count() }})
                </button>
                <button onclick="switchTab('history')" id="historyTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📊 Reconciliation History ({{ $reconciliations->count() }})
                </button>
                <button onclick="switchTab('latest')" id="latestTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Latest Reconciliation
                </button>
            </nav>
        </div>

        <!-- Unreconciled Transactions -->
        <div id="unreconciledContent" class="p-6">
            @if($unreconciledTransactions->count() > 0)
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Transactions Pending Reconciliation</h3>
                <button onclick="reconcileSelected()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Reconcile Selected
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b w-8">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Transaction Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unreconciledTransactions as $transaction)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <input type="checkbox" class="transaction-checkbox" value="{{ $transaction->id }}">
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">#{{ $transaction->payment_ref ?? $transaction->transaction_ref }}</p>
                                @if($transaction->loan)
                                <p class="text-gray-500 text-sm">Loan: {{ $transaction->loan->loan_number }}</p>
                                <p class="text-gray-500 text-xs">{{ $transaction->loan->user->name }}</p>
                                @elseif($transaction->savingsTransaction)
                                <p class="text-gray-500 text-sm">Savings: {{ $transaction->savingsTransaction->type }}</p>
                                <p class="text-gray-500 text-xs">{{ $transaction->savingsTransaction->user->name }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                @if($transaction->loan_id)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Loan Payment</span>
                                @elseif($transaction->savings_transaction_id)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Savings</span>
                                @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Other</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">
                                    {{ $transaction->amount >= 0 ? '+' : '' }}KES {{ number_format($transaction->amount, 2) }}
                                </p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900">{{ $transaction->payment_date?->format('d M Y') ?? $transaction->transaction_date?->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">Unreconciled</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">All Transactions Reconciled</h3>
                <p class="text-gray-500">No unreconciled transactions found.</p>
            </div>
            @endif
        </div>

        <!-- Reconciliation History -->
        <div id="historyContent" class="p-6 hidden">
            @if($reconciliations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Bank Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">System Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Difference</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Performed By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reconciliations as $reconciliation)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="text-gray-900">{{ $reconciliation->reconciliation_date->format('d M Y') }}</p>
                                <p class="text-gray-500 text-xs">{{ $reconciliation->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">KES {{ number_format($reconciliation->bank_statement_balance, 2) }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">KES {{ number_format($reconciliation->system_balance, 2) }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-bold {{ $reconciliation->difference == 0 ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $reconciliation->difference >= 0 ? '+' : '' }}KES {{ number_format($reconciliation->difference, 2) }}
                                </p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium 
                                    {{ $reconciliation->status === 'balanced' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($reconciliation->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900">{{ $reconciliation->performedBy->name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <button onclick="viewReconciliation({{ $reconciliation->id }})" 
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $reconciliations->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Reconciliation History</h3>
                <p class="text-gray-500">Run your first reconciliation to see history here.</p>
            </div>
            @endif
        </div>

        <!-- Latest Reconciliation -->
        <div id="latestContent" class="p-6 hidden">
            @if($latestReconciliation)
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Latest Reconciliation</h3>
                        <p class="text-gray-600">{{ $latestReconciliation->reconciliation_date->format('F d, Y') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $latestReconciliation->status === 'balanced' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                        {{ ucfirst($latestReconciliation->status) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-gray-500 text-sm mb-1">Bank Statement Balance</p>
                        <p class="text-2xl font-bold text-blue-600">KES {{ number_format($latestReconciliation->bank_statement_balance, 2) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border">
                        <p class="text-gray-500 text-sm mb-1">System Balance</p>
                        <p class="text-2xl font-bold text-green-600">KES {{ number_format($latestReconciliation->system_balance, 2) }}</p>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg border">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Difference</p>
                            <p class="text-3xl font-bold {{ $latestReconciliation->difference == 0 ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $latestReconciliation->difference >= 0 ? '+' : '' }}KES {{ number_format($latestReconciliation->difference, 2) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 text-sm">Performed by</p>
                            <p class="font-medium text-gray-900">{{ $latestReconciliation->performedBy->name ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-xs">{{ $latestReconciliation->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($latestReconciliation->notes)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-gray-500 text-sm mb-1">Notes</p>
                        <p class="text-gray-700">{{ $latestReconciliation->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-4xl mb-4">📅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Recent Reconciliation</h3>
                <p class="text-gray-500">Run a reconciliation to see details here.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Reconciliation Tools -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Reconciliation Tools</h3>
            <div class="space-y-3">
                <button onclick="downloadReconciliationTemplate()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📥 Download Reconciliation Template</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="importBankStatement()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📄 Import Bank Statement (CSV)</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="autoReconcile()" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>🤖 Auto-Reconcile Transactions</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="findDiscrepancies()" 
                        class="w-full text-left px-4 py-3 bg-orange-50 hover:bg-orange-100 text-orange-800 rounded-lg text-sm flex justify-between items-center">
                    <span>🔍 Find Discrepancies</span>
                    <span class="text-orange-600">→</span>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Reconciliation Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('monthly')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📅 Monthly Reconciliation Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('discrepancies')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>⚠️ Discrepancy Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('audit')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>🔐 Audit Trail Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportReconciliationData()" 
                        class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center">
                    <span>💾 Export Reconciliation Data</span>
                    <span class="text-green-600">→</span>
                </button>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
// Tab switching
function switchTab(tabName) {
    // Hide all content
    ['unreconciled', 'history', 'latest'].forEach(tab => {
        document.getElementById(tab + 'Content').classList.add('hidden');
        document.getElementById(tab + 'Tab').classList.remove('border-b-2', 'border-orange-600', 'text-orange-700');
        document.getElementById(tab + 'Tab').classList.add('text-gray-500');
    });
    
    // Show selected content
    document.getElementById(tabName + 'Content').classList.remove('hidden');
    
    // Activate selected tab
    document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-orange-600', 'text-orange-700');
    document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');
}

// Checkbox functions
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.transaction-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function getSelectedTransactions() {
    const checkboxes = document.querySelectorAll('.transaction-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Action functions
function calculateDifference() {
    const bankBalance = parseFloat(document.getElementById('bank_statement_balance').value) || 0;
    const systemBalance = {{ $reconciliationStats['system_balance'] }};
    const difference = bankBalance - systemBalance;
    
    alert(`Bank Balance: KES ${bankBalance.toLocaleString()}\n` +
          `System Balance: KES ${systemBalance.toLocaleString()}\n` +
          `Difference: ${difference >= 0 ? '+' : ''}KES ${difference.toLocaleString()}\n` +
          `Status: ${difference === 0 ? 'BALANCED' : 'UNBALANCED'}`);
}

function runReconciliation() {
    const bankBalance = document.getElementById('bank_statement_balance').value;
    if (!bankBalance || isNaN(bankBalance)) {
        alert('Please enter bank statement balance');
        return;
    }
    
    if (confirm('Run bank reconciliation?')) {
        const form = document.getElementById('reconciliationForm');
        const formData = new FormData(form);
        
        fetch('/treasurer/reconciliation/run', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reconciliation completed successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function uploadStatement() {
    document.getElementById('bank_statement_file').click();
}

function reconcileSelected() {
    const selectedIds = getSelectedTransactions();
    if (selectedIds.length === 0) {
        alert('Please select transactions to reconcile');
        return;
    }
    
    if (confirm(`Reconcile ${selectedIds.length} selected transactions?`)) {
        fetch('/treasurer/reconciliation/reconcile-transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ transaction_ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Reconciled ${data.count} transactions successfully!`);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function viewReconciliation(id) {
    window.location.href = `/treasurer/reconciliation/${id}`;
}

function downloadReconciliationTemplate() {
    window.location.href = '/treasurer/reconciliation/template';
}

function importBankStatement() {
    window.location.href = '/treasurer/reconciliation/import';
}

function autoReconcile() {
    if (confirm('Run auto-reconciliation? This will attempt to match transactions automatically.')) {
        fetch('/treasurer/reconciliation/auto', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Auto-reconciliation completed. Matched ${data.matched} transactions.`);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function findDiscrepancies() {
    window.location.href = '/treasurer/reconciliation/discrepancies';
}

function generateReport(type) {
    window.location.href = `/treasurer/reports/reconciliation/${type}`;
}

function exportReconciliationData() {
    if (confirm('Export reconciliation data to Excel?')) {
        window.location.href = '/treasurer/reconciliation/export';
    }
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('unreconciled');
});
</script>
@endsection