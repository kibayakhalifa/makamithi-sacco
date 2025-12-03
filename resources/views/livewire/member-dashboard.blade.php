@extends('components.dashboard-layout')

@section('title', 'Member Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Welcome back, {{ $member['name'] }}!</h1>
                <p class="text-blue-100 mt-2">Member No: {{ $member['member_number'] }} | Department: {{ $member['department'] }}</p>
            </div>
            <div class="text-right">
                <p class="text-blue-100">Employment Date</p>
                <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($member['employment_date'])->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Savings Card -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Savings</h3>
                    <p class="text-3xl font-bold mt-2">KES {{ number_format($savingsBalance, 2) }}</p>
                    <p class="text-green-600 text-sm mt-1">1.5x Loan Qualification: KES {{ number_format($savingsBalance * 1.5, 2) }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <span class="text-green-600 text-2xl">💰</span>
                </div>
            </div>
            <button class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition">
                View Savings Details
            </button>
        </div>

        <!-- Loans Card -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold uppercase">Active Loans</h3>
                    <p class="text-3xl font-bold mt-2">KES {{ number_format($loanBalance, 2) }}</p>
                    <p class="text-red-600 text-sm mt-1">{{ count($activeLoans) }} active loan(s)</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <span class="text-red-600 text-2xl">📝</span>
                </div>
            </div>
            <button class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-semibold transition">
                View Loan Details
            </button>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Quick Actions</h3>
            <div class="mt-4 space-y-3">
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center">
                    📝 Apply for Loan
                </button>
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center">
                    💰 Top Up Savings
                </button>
                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center">
                    📄 Download Statement
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Transactions & Active Loans -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">View All →</a>
            </div>
            
            <div class="space-y-4">
                @foreach($recentTransactions as $transaction)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg border">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full {{ $transaction['type'] === 'Savings' ? 'bg-green-100' : 'bg-red-100' }}">
                            <span class="{{ $transaction['type'] === 'Savings' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction['type'] === 'Savings' ? '💰' : '📝' }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold">{{ $transaction['description'] }}</h4>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($transaction['date'])->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold {{ $transaction['type'] === 'Savings' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction['type'] === 'Savings' ? '+' : '-' }} KES {{ number_format($transaction['amount'], 2) }}
                        </p>
                        <p class="text-gray-500 text-sm">{{ $transaction['type'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Active Loans</h2>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">View All →</a>
            </div>
            
            @foreach($activeLoans as $loan)
            <div class="p-4 border rounded-lg mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-bold text-lg">Loan #{{ $loan['id'] }}</h4>
                        <p class="text-gray-600">Taken: {{ \Carbon\Carbon::parse($loan['due_date'])->subMonths(24)->format('M Y') }}</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ ucfirst($loan['status']) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <p class="text-gray-500 text-sm">Original Amount</p>
                        <p class="font-bold">KES {{ number_format($loan['amount'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Current Balance</p>
                        <p class="font-bold">KES {{ number_format($loan['balance'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Monthly Payment</p>
                        <p class="font-bold">KES {{ number_format($loan['monthly_payment'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Next Due Date</p>
                        <p class="font-bold">{{ \Carbon\Carbon::parse($loan['due_date'])->format('d M Y') }}</p>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Repayment Progress</span>
                        <span>{{ number_format((($loan['amount'] - $loan['balance']) / $loan['amount']) * 100, 1) }}%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div 
                            class="h-full bg-blue-500 rounded-full" 
                            style="width: {{ (($loan['amount'] - $loan['balance']) / $loan['amount']) * 100 }}%">
                        </div>
                    </div>
                    
                    <!-- Top-up eligibility badge -->
                    @if(($loan['amount'] - $loan['balance']) / $loan['amount'] >= 0.5)
                    <div class="mt-3 inline-flex items-center bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                        ✅ Eligible for Top-up Loan
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            
            @if(count($activeLoans) === 0)
            <div class="text-center py-8 text-gray-500">
                <p class="text-4xl mb-4">📝</p>
                <p class="text-lg">No active loans</p>
                <p class="text-sm mt-2">You can apply for a loan up to 1.5x your savings balance</p>
                <button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">
                    Apply for Loan
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Notifications Section -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Notifications & Alerts</h2>
        <div class="space-y-3">
            <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                <span class="text-blue-500 mr-3">ℹ️</span>
                <div>
                    <p class="font-semibold">Your savings qualify for KES {{ number_format($savingsBalance * 1.5, 2) }} loan</p>
                    <p class="text-sm text-gray-600">Apply anytime with our 5% fixed interest rate</p>
                </div>
            </div>
            <div class="flex items-start p-3 bg-yellow-50 rounded-lg">
                <span class="text-yellow-500 mr-3">⏰</span>
                <div>
                    <p class="font-semibold">Next loan payment due in 5 days</p>
                    <p class="text-sm text-gray-600">KES 6,562.50 will be deducted from your payroll</p>
                </div>
            </div>
            <div class="flex items-start p-3 bg-green-50 rounded-lg">
                <span class="text-green-500 mr-3">🎉</span>
                <div>
                    <p class="font-semibold">Year-end bonus coming in December</p>
                    <p class="text-sm text-gray-600">Based on your savings and loan repayment history</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection