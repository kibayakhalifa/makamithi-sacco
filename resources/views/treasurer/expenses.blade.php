@extends('components.dashboard-layout')

@section('title', 'Expenses Tracking')

@section('content')
<div class="space-y-6 font-sans">

    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <span class="text-orange-700 font-bold text-lg">4</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Expenses Tracking</h1>
                </div>
                <p class="text-orange-800">Track and manage SACCO operational expenses and payments</p>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-orange-600 text-sm font-medium">Monthly Expenses</p>
                    <p class="text-4xl font-bold text-gray-900">KES {{ number_format($expenseStats['month_expenses'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $expenseStats['pending_expenses'] }} pending</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Expenses</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($expenseStats['total_expenses'], 2) }}</p>
                    <p class="text-gray-500 text-sm mt-1">All time</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-xl">
                    <span class="text-orange-600 text-xl">📊</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">This Month</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($expenseStats['month_expenses'], 2) }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ now()->format('F') }} expenses</p>
                </div>
                <div class="bg-red-50 p-3 rounded-xl">
                    <span class="text-red-600 text-xl">💸</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $expenseStats['pending_expenses'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting approval</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-xl">
                    <span class="text-yellow-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Approved</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $expenseStats['approved_expenses'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Ready for payment</p>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('pending')" id="pendingTab" 
                        class="px-6 py-4 font-medium border-b-2 border-orange-600 text-orange-700 whitespace-nowrap">
                    ⏳ Pending Approval ({{ $pendingExpenses->count() }})
                </button>
                <button onclick="switchTab('approved')" id="approvedTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Approved Unpaid ({{ $approvedUnpaid->count() }})
                </button>
                <button onclick="switchTab('all')" id="allTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📋 All Expenses ({{ $expenses->count() }})
                </button>
                <button onclick="switchTab('categories')" id="categoriesTab"
                        class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📊 By Category
                </button>
            </nav>
        </div>

        <!-- Pending Expenses -->
        <div id="pendingContent" class="p-6">
            @if($pendingExpenses->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Expense Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Requested By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingExpenses as $expense)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">KES {{ number_format($expense->amount, 2) }}</p>
                                <p class="text-gray-500 text-sm">#{{ $expense->expense_number }}</p>
                                <p class="text-gray-500 text-xs">{{ $expense->description }}</p>
                                <p class="text-gray-500 text-xs">Date: {{ $expense->expense_date->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $expense->category->color_class ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">{{ $expense->requestedBy->name ?? 'N/A' }}</p>
                                <p class="text-gray-500 text-xs">{{ $expense->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <button onclick="approveExpense({{ $expense->id }})" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Approve
                                    </button>
                                    <button onclick="rejectExpense({{ $expense->id }})" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Reject
                                    </button>
                                    <a href="{{ route('expenses.show', $expense->id) }}" 
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Expenses</h3>
                <p class="text-gray-500">All expenses have been approved or rejected.</p>
            </div>
            @endif
        </div>

        <!-- Approved Unpaid -->
        <div id="approvedContent" class="p-6 hidden">
            @if($approvedUnpaid->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Expense Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Approved By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedUnpaid as $expense)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">KES {{ number_format($expense->approved_amount ?? $expense->amount, 2) }}</p>
                                <p class="text-gray-500 text-sm">#{{ $expense->expense_number }}</p>
                                <p class="text-gray-500 text-xs">{{ $expense->description }}</p>
                                <p class="text-gray-500 text-xs">Approved: {{ $expense->approved_date?->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $expense->category->color_class ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">{{ $expense->approvedBy->name ?? 'N/A' }}</p>
                                <p class="text-gray-500 text-xs">{{ $expense->approved_date?->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <button onclick="payExpense({{ $expense->id }})" 
                                            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Pay Now
                                    </button>
                                    <button onclick="issueCheque({{ $expense->id }})" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Issue Cheque
                                    </button>
                                    <a href="{{ route('expenses.show', $expense->id) }}" 
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-4xl mb-4">💸</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Approved Expenses</h3>
                <p class="text-gray-500">All approved expenses have been paid.</p>
            </div>
            @endif
        </div>

        <!-- All Expenses -->
        <div id="allContent" class="p-6 hidden">
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">All Expenses</h3>
                <div class="flex gap-2">
                    <select id="filterStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="paid">Paid</option>
                    </select>
                    <button onclick="exportExpenses()" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                        Export
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Expense Details</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Payment</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-4">
                                <p class="font-bold text-gray-900">KES {{ number_format($expense->approved_amount ?? $expense->amount, 2) }}</p>
                                <p class="text-gray-500 text-sm">#{{ $expense->expense_number }}</p>
                                <p class="text-gray-500 text-xs">{{ $expense->description }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $expense->category->color_class ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $expense->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($expense->status === 'pending' ? 'bg-orange-100 text-orange-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($expense->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if($expense->payment_status === 'paid')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Paid</span>
                                <p class="text-gray-500 text-xs">{{ $expense->payment_method }}</p>
                                @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900">{{ $expense->expense_date->format('d M Y') }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        </div>

        <!-- Categories -->
        <div id="categoriesContent" class="p-6 hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Expenses by Category</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pie Chart Container -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="font-medium text-gray-900 mb-4">Category Distribution</h4>
                    <div class="h-64 flex items-center justify-center">
                        <!-- This would be a chart in real implementation -->
                        <div class="text-center">
                            <div class="text-4xl mb-4">📊</div>
                            <p class="text-gray-500">Expense breakdown by category</p>
                        </div>
                    </div>
                </div>
                
                <!-- Category List -->
                <div>
                    <div class="space-y-4">
                        @foreach($expensesByCategory as $category)
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium text-gray-900">{{ $category->category->name ?? 'Uncategorized' }}</span>
                                <span class="font-bold text-orange-600">KES {{ number_format($category->total, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $percentage = ($category->total / $expenseStats['total_expenses']) * 100;
                                @endphp
                                <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="text-gray-500 text-xs mt-2">{{ number_format($percentage, 1) }}% of total</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Monthly Trend -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="font-medium text-gray-900 mb-4">Monthly Expense Trend</h4>
                <div class="h-48">
                    <!-- This would be a line chart in real implementation -->
                    <div class="text-center py-8">
                        <div class="text-3xl mb-2">📈</div>
                        <p class="text-gray-500">Monthly expense visualization</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget & Reports -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Budget Overview</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Office Supplies</span>
                        <span class="text-gray-900 text-sm font-medium">KES 35,000 / 50,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 70%"></div>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">70% used</p>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Utilities</span>
                        <span class="text-gray-900 text-sm font-medium">KES 28,000 / 30,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 93%"></div>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">93% used</p>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Travel & Meetings</span>
                        <span class="text-gray-900 text-sm font-medium">KES 75,000 / 100,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">75% used</p>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 text-sm">Total Budget</span>
                        <span class="text-gray-900 text-sm font-medium">KES 138,000 / 180,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 77%"></div>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">77% used • KES 42,000 remaining</p>
                </div>
            </div>
            
            <div class="mt-6">
                <button onclick="updateBudget()" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-xl font-medium">
                    📝 Update Budget
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Expense Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('monthly')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📅 Monthly Expense Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('category')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>📊 Category Analysis</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('budget')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>💰 Budget vs Actual</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('tax')" 
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                    <span>🧾 Tax Deductible Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportExpenseData()" 
                        class="w-full text-left px-4 py-3 bg-orange-50 hover:bg-orange-100 text-orange-800 rounded-lg text-sm flex justify-between items-center">
                    <span>💾 Export Expense Data</span>
                    <span class="text-orange-600">→</span>
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
    ['pending', 'approved', 'all', 'categories'].forEach(tab => {
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

// Action functions
function approveExpense(expenseId) {
    const approvedAmount = prompt('Approved amount (KES):');
    if (approvedAmount && !isNaN(approvedAmount)) {
        const notes = prompt('Approval notes (optional):');
        fetch(`/treasurer/expenses/${expenseId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                approved_amount: parseFloat(approvedAmount),
                approval_notes: notes || ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Expense approved successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function rejectExpense(expenseId) {
    const reason = prompt('Reason for rejection:');
    if (reason) {
        fetch(`/treasurer/expenses/${expenseId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Expense rejected.');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function payExpense(expenseId) {
    const paymentMethod = prompt('Payment method (cash/cheque/bank transfer):');
    if (paymentMethod) {
        const reference = prompt('Payment reference (optional):');
        fetch(`/treasurer/expenses/${expenseId}/pay`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                payment_method: paymentMethod,
                reference_number: reference || ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Expense paid successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function issueCheque(expenseId) {
    const chequeNumber = prompt('Cheque number:');
    if (chequeNumber) {
        window.location.href = `/treasurer/expenses/${expenseId}/issue-cheque?cheque_number=${chequeNumber}`;
    }
}

function exportExpenses() {
    if (confirm('Export expense data to Excel?')) {
        const status = document.getElementById('filterStatus').value;
        window.location.href = `/treasurer/expenses/export?status=${status}`;
    }
}

function updateBudget() {
    window.location.href = '/treasurer/budget';
}

function generateReport(type) {
    window.location.href = `/treasurer/reports/expenses/${type}`;
}

function exportExpenseData() {
    if (confirm('Export all expense data to Excel?')) {
        window.location.href = '/treasurer/expenses/export-all';
    }
}

// Filter functionality
document.getElementById('filterStatus')?.addEventListener('change', function(e) {
    const status = e.target.value;
    const rows = document.querySelectorAll('#allContent tbody tr');
    
    rows.forEach(row => {
        const rowStatus = row.querySelector('td:nth-child(3) span').textContent.toLowerCase();
        if (!status || rowStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('pending');
});
</script>
@endsection