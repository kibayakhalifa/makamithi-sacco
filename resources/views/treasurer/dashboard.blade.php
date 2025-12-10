@extends('components.dashboard-layout')

@section('title', 'Treasurer Dashboard')

@section('content')
<div class="space-y-6 font-sans">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Treasurer Dashboard</h1>
                <p class="text-green-800 mt-1">Welcome, {{ auth()->user()->name }} — Manage all financial operations</p>
            </div>
            <div class="text-right">
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-green-600 text-sm font-medium">Sacco Balance</p>
                    <p class="text-4xl font-bold text-gray-900">KES 12.4M</p>
                    <p class="text-gray-500 text-xs mt-1">Last updated: Today, 9:00 AM</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES 8.24M</p>
                    <div class="flex items-center mt-1">
                        <span class="text-green-600 text-sm font-medium">↑ 12%</span>
                        <span class="text-gray-500 text-xs ml-2">from last month</span>
                    </div>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-xl">💰</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Loans</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES 4.21M</p>
                    <div class="flex items-center mt-1">
                        <span class="text-green-600 text-sm font-medium">89 loans</span>
                        <span class="text-gray-500 text-xs ml-2">active</span>
                    </div>
                </div>
                <div class="bg-orange-50 p-3 rounded-xl">
                    <span class="text-orange-600 text-xl">📝</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Payments</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES 450K</p>
                    <div class="flex items-center mt-1">
                        <span class="text-orange-600 text-sm font-medium">15 pending</span>
                        <span class="text-gray-500 text-xs ml-2">to process</span>
                    </div>
                </div>
                <div class="bg-orange-50 p-3 rounded-xl">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Cash at Bank</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">KES 12.45M</p>
                    <div class="flex items-center mt-1">
                        <span class="text-green-600 text-sm font-medium">Equity Bank</span>
                        <span class="text-gray-500 text-xs ml-2">A/C: 123456</span>
                    </div>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <span class="text-green-600 text-xl">🏦</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 7-Key Treasurer Reports -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    <span class="text-green-600">📋</span> Treasurer's 7-Key Reports
                </h2>
                <p class="text-gray-500 text-sm mt-1">Click any section to manage</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs px-3 py-1 bg-green-100 text-green-800 rounded-full">1-7 Numbered</span>
                <span class="text-xs px-3 py-1 bg-orange-100 text-orange-800 rounded-full">Green+Orange Theme</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- 1. Payment Processing -->
            <a href="{{ route('treasurer.payments') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-700 font-bold text-lg">1</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700">Payment Processing</h3>
                            <p class="text-gray-500 text-xs">Disbursements & transfers</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pending:</span>
                            <span class="font-semibold text-orange-600">15 payments</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Today:</span>
                            <span class="font-semibold text-gray-900">KES 120,000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Cheques:</span>
                            <span class="font-semibold">8 to issue</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> View Payments
                        </span>
                    </div>
                </div>
            </a>

            <!-- 2. Loans Management -->
            <a href="{{ route('treasurer.loans') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">2</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700">Loans Management</h3>
                            <p class="text-gray-500 text-xs">Approved & pending loans</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Active Loans:</span>
                            <span class="font-semibold text-gray-900">KES 4.21M</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pending:</span>
                            <span class="font-semibold text-orange-600">12 awaiting</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Rejected:</span>
                            <span class="font-semibold text-red-600">5 loans</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> Manage Loans
                        </span>
                    </div>
                </div>
            </a>

            <!-- 3. Savings Summary -->
            <a href="{{ route('treasurer.savings') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">3</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700">Savings Summary</h3>
                            <p class="text-gray-500 text-xs">Member savings & withdrawals</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Savings:</span>
                            <span class="font-semibold text-gray-900">KES 8.24M</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Members:</span>
                            <span class="font-semibold">156 accounts</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Withdrawals:</span>
                            <span class="font-semibold text-orange-600">4 pending</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> View Savings
                        </span>
                    </div>
                </div>
            </a>

            <!-- 4. Expenses Tracking -->
            <a href="{{ route('treasurer.expenses') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-orange-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-700 font-bold text-lg">4</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-orange-700">Expenses Tracking</h3>
                            <p class="text-gray-500 text-xs">Sacco operational costs</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">This Month:</span>
                            <span class="font-semibold text-gray-900">KES 45,000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pending:</span>
                            <span class="font-semibold text-orange-600">3 approvals</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Budget Used:</span>
                            <span class="font-semibold">62%</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-orange-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> Track Expenses
                        </span>
                    </div>
                </div>
            </a>

            <!-- 5. Cheque Management -->
            <a href="{{ route('treasurer.cheques') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">5</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700">Cheque Management</h3>
                            <p class="text-gray-500 text-xs">Issue & clearance</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">To Issue:</span>
                            <span class="font-semibold text-orange-600">8 cheques</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Cleared:</span>
                            <span class="font-semibold text-gray-900">KES 210,000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Outstanding:</span>
                            <span class="font-semibold">KES 320,000</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> Manage Cheques
                        </span>
                    </div>
                </div>
            </a>

            <!-- 6. Bank Reconciliation -->
            <a href="{{ route('treasurer.reconciliation') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">6</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700">Bank Reconciliation</h3>
                            <p class="text-gray-500 text-xs">Bank vs system records</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Last Recon:</span>
                            <span class="font-semibold text-gray-900">Yesterday</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Difference:</span>
                            <span class="font-semibold text-green-600">KES 0.00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Balanced ✓</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-green-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> Reconcile Now
                        </span>
                    </div>
                </div>
            </a>

            <!-- 7. Financial Reports -->
            <a href="{{ route('treasurer.financial-reports') }}" class="group">
                <div class="border border-gray-200 rounded-xl p-5 hover:border-orange-300 hover:shadow-lg transition-all duration-200 bg-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="text-orange-700 font-bold text-lg">7</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-orange-700">Financial Reports</h3>
                            <p class="text-gray-500 text-xs">Generate & export reports</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">This Month:</span>
                            <span class="font-semibold text-gray-900">4 reports</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Due Today:</span>
                            <span class="font-semibold text-orange-600">Monthly Report</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Formats:</span>
                            <span class="font-semibold">PDF, Excel, CSV</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <span class="text-orange-600 text-xs font-medium flex items-center gap-1">
                            <span>→</span> Generate Reports
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Summary Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 p-4 rounded-xl">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-green-600">✓</span>
                        </div>
                        <div>
                            <p class="text-sm text-green-800 font-medium">All Systems Operational</p>
                            <p class="text-xs text-green-600">Last checked: 5 mins ago</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 p-4 rounded-xl">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="text-orange-600">⏳</span>
                        </div>
                        <div>
                            <p class="text-sm text-orange-800 font-medium">Action Required</p>
                            <p class="text-xs text-orange-600">15 pending items</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-600">📊</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-medium">Overall Health</p>
                            <p class="text-xs text-gray-600">94% positive metrics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Transactions -->
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                <a href="#" class="text-green-600 text-sm font-medium hover:text-green-700">View All →</a>
            </div>
            
            <div class="space-y-3">
                @php
                    $transactions = [
                        ['type' => 'Loan Disbursement', 'member' => 'John Mule', 'amount' => 150000, 'date' => 'Today, 9:30 AM', 'status' => 'completed', 'icon' => '💰'],
                        ['type' => 'Savings Withdrawal', 'member' => 'Jane Wanjiru', 'amount' => 50000, 'date' => 'Yesterday, 2:15 PM', 'status' => 'pending', 'icon' => '🏧'],
                        ['type' => 'Expense Payment', 'member' => 'Office Rent', 'amount' => 25000, 'date' => 'Yesterday, 10:00 AM', 'status' => 'completed', 'icon' => '🏢'],
                        ['type' => 'Loan Repayment', 'member' => 'Peter Kamau', 'amount' => 12000, 'date' => '2 days ago', 'status' => 'completed', 'icon' => '💳'],
                        ['type' => 'Bank Deposit', 'member' => 'Cash Collection', 'amount' => 185000, 'date' => '3 days ago', 'status' => 'completed', 'icon' => '🏦'],
                    ];
                @endphp
                
                @foreach($transactions as $transaction)
                <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center 
                            {{ $transaction['status'] === 'completed' ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-600' }}">
                            <span class="text-lg">{{ $transaction['icon'] }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaction['type'] }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction['member'] }}</p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-bold text-gray-900">
                            {{ $transaction['type'] === 'Expense Payment' ? '-' : '' }}KES {{ number_format($transaction['amount'], 2) }}
                        </p>
                        <p class="text-gray-500 text-xs">{{ $transaction['date'] }}</p>
                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full 
                            {{ $transaction['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ ucfirst($transaction['status']) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
            
            <div class="space-y-3">
                <a href="{{ route('treasurer.payments') }}" 
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                    <span>💳</span> Process Payments
                </a>
                
                <button onclick="recordDeposit()"
                   class="w-full bg-green-50 hover:bg-green-100 text-green-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                    <span>💰</span> Record Bank Deposit
                </button>
                
                <button onclick="generateReport()"
                   class="w-full bg-orange-50 hover:bg-orange-100 text-orange-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                    <span>📊</span> Daily Report
                </button>
                
                <button onclick="checkReconciliation()"
                   class="w-full bg-gray-50 hover:bg-gray-100 text-gray-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                    <span>✅</span> Quick Reconciliation
                </button>
                
                <button onclick="viewAuditTrail()"
                   class="w-full bg-gray-50 hover:bg-gray-100 text-gray-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2 transition">
                    <span>👁️</span> View Audit Trail
                </button>
            </div>
            
            <!-- Upcoming Deadlines -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="font-medium text-gray-900 mb-3">Upcoming Deadlines</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Monthly Report</span>
                        <span class="text-orange-600 font-medium">Tomorrow</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Bank Statement</span>
                        <span class="text-gray-900 font-medium">In 2 days</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Tax Filing</span>
                        <span class="text-gray-900 font-medium">15th March</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript for Quick Actions -->
<script>
function recordDeposit() {
    const amount = prompt('Enter deposit amount (KES):');
    if (amount && !isNaN(amount)) {
        alert(`Recording deposit of KES ${parseFloat(amount).toLocaleString()}...`);
        // AJAX call here
    }
}

function generateReport() {
    alert('Generating daily financial report...');
    // AJAX call here
}

function checkReconciliation() {
    alert('Checking bank reconciliation status...');
    // AJAX call here
}

function viewAuditTrail() {
    alert('Opening audit trail view...');
    // AJAX call here
}
</script>
@endsection