@extends('components.dashboard-layout')

@section('title', 'Treasurer Dashboard')

@section('content')
<div class="space-y-6 font-sans text-gray-900">

    <!-- Welcome Banner -->
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight">Treasurer Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome, {{ auth()->user()->name }} — manage payments & financial records</p>
            </div>

            <div class="text-right">
                <p class="text-gray-400 text-sm">Sacco Balance</p>
                <p class="text-4xl font-semibold tracking-tight">KES 12.4M</p>
            </div>
        </div>
    </div>

    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Savings -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm uppercase tracking-wide">Total Savings</h3>
                    <p class="text-3xl font-semibold mt-2 tracking-tight">KES 8.24M</p>
                    <p class="text-gray-500 text-sm mt-1">+12% from last month</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-xl text-gray-600">💰</div>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm uppercase tracking-wide">Active Loans</h3>
                    <p class="text-3xl font-semibold mt-2 tracking-tight">KES 4.21M</p>
                    <p class="text-gray-500 text-sm mt-1">89 active loans</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-xl text-gray-600">📝</div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm uppercase tracking-wide">Pending Payments</h3>
                    <p class="text-3xl font-semibold mt-2 tracking-tight">KES 450K</p>
                    <p class="text-gray-500 text-sm mt-1">15 pending cheques</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-xl text-gray-600">⏳</div>
            </div>
        </div>
    </div>

    <!-- Summary + Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Financial Summary -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight mb-4">Financial Summary</h3>

            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">Cash in Bank</span>
                    <span class="font-medium">KES 12,450,000</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">Cash in Hand</span>
                    <span class="font-medium">KES 25,000</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">Total Assets</span>
                    <span class="font-medium">KES 12,475,000</span>
                </div>

                <div class="flex justify-between items-center p-3 bg-gray-100 rounded-lg">
                    <span class="text-gray-700">Net Position</span>
                    <span class="font-semibold">+8,265,000</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight mb-4">Quick Actions</h3>

            <div class="space-y-3">
                <a href="{{ route('treasurer.payments') }}"
                   class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-lg font-medium transition">
                    Process Payments
                </a>

                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                    Bank Deposit
                </button>

                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                    Generate Report
                </button>

                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                    Record Expense
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold tracking-tight">Recent Transactions</h2>
            <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-gray-700 transition">
                View All
            </button>
        </div>

        <div class="space-y-4">

            @php
                $transactions = [
                    ['type' => 'Loan Disbursement', 'member' => 'John Mule', 'amount' => 150000, 'date' => 'Today', 'status' => 'Completed'],
                    ['type' => 'Savings Withdrawal', 'member' => 'Jane Wanjiru', 'amount' => 50000, 'date' => 'Yesterday', 'status' => 'Pending'],
                    ['type' => 'Loan Disbursement', 'member' => 'Peter Kamau', 'amount' => 75000, 'date' => '2 days ago', 'status' => 'Completed'],
                    ['type' => 'Expense', 'member' => 'Sacco Office', 'amount' => 15000, 'date' => '3 days ago', 'status' => 'Completed'],
                ];
            @endphp

            @foreach($transactions as $transaction)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-3 rounded-full text-gray-600 text-lg">
                        {{ $transaction['type'] === 'Expense' ? '💸' : '💳' }}
                    </div>

                    <div>
                        <p class="font-medium text-gray-800">{{ $transaction['type'] }}</p>
                        <p class="text-gray-500 text-sm">{{ $transaction['member'] }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="font-semibold text-gray-900">
                        {{ $transaction['type'] === 'Expense' ? '-' : '' }}KES {{ number_format($transaction['amount'], 2) }}
                    </p>
                    <p class="text-gray-500 text-sm">{{ $transaction['date'] }}</p>

                    <span class="inline-block mt-1 px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                        {{ $transaction['status'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
