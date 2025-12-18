@extends('components.dashboard-layout')

@section('title', 'Member Dashboard')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Dashboard</h1>
                    <p class="text-gray-500 mt-1">
                        Welcome {{ auth()->user()->name }} — here is an overview of your savings and loan status.
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Savings -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-blue-700 font-medium">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-blue-900">
                            KES {{ number_format($stats['total_savings'] ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-blue-600 mt-1">Available for loans</p>
                    </div>
                    <div class="text-3xl text-blue-500">💰</div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-green-700 font-medium">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-green-900">{{ $stats['active_loans_count'] ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">Currently active</p>
                    </div>
                    <div class="text-3xl text-green-500">📄</div>
                </div>
            </div>

            <!-- Loan Balance -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-purple-700 font-medium">Loan Balance</p>
                        <p class="text-3xl font-semibold mt-2 text-purple-900">
                            KES {{ number_format($stats['total_loan_balance'] ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-purple-600 mt-1">Outstanding amount</p>
                    </div>
                    <div class="text-3xl text-purple-500">💸</div>
                </div>
            </div>

            <!-- Withdrawable Amount -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-orange-700 font-medium">
                            @if(auth()->user()->sacco_status === 'active')
                                Loan Eligibility
                            @else
                                Withdrawable
                            @endif
                        </p>
                        <p class="text-3xl font-semibold mt-2 text-orange-900">
                            KES {{ number_format($stats['loan_eligibility'] ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-orange-600 mt-1">
                            @if(auth()->user()->sacco_status === 'active')
                                For new loans (1.5× savings)
                            @else
                                Available to withdraw
                            @endif
                        </p>
                    </div>
                    <div class="text-3xl text-orange-500">🏦</div>
                </div>
            </div>
        </div>

        <!-- Recent Savings Activity -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Recent Savings Activity</h2>
                <a href="{{ route('member.savings.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            @if($recentTransactions && $recentTransactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Amount</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Type</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentTransactions as $index => $transaction)
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <p class="font-medium text-gray-900">{{ $transaction->transaction_date ? $transaction->transaction_date->format('d M Y') : $transaction->created_at->format('d M Y') }}</p>
                                    <p class="text-gray-500 text-xs">{{ $transaction->created_at->diffForHumans() }}</p>
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300">
                                    {{ $transaction->transaction_ref ?? 'TRX-' . $transaction->id }}
                                </td>

                                <td class="px-6 py-4 font-semibold border-r border-gray-300 {{ $transaction->type !== 'withdrawal' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type !== 'withdrawal' ? '+' : '-' }}KES {{ number_format(abs($transaction->amount), 2) }}
                                </td>

                                <td class="px-6 py-4 border-r border-gray-300">
                                    <span class="text-gray-700">
                                        @if($transaction->type === 'payroll_deduction')
                                            Payroll Deduction
                                        @elseif($transaction->type === 'voluntary_deposit')
                                            Voluntary Deposit
                                        @elseif($transaction->type === 'interest_credit')
                                            Interest Credit
                                        @elseif($transaction->type === 'withdrawal')
                                            Withdrawal
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $transaction->type ?? 'deposit')) }}
                                        @endif
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($transaction->status === 'completed')
                                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                            ✓ Completed
                                        </span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                            ⏳ Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                            ✗ {{ ucfirst($transaction->status ?? 'unknown') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <div class="text-5xl mb-4 text-gray-400">💰</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No Recent Transactions</h3>
                <p class="text-gray-500 mb-6">You haven't made any savings transactions yet.</p>
                <a href="{{ route('member.savings.index') }}"
                    class="inline-block px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    View Savings Account
                </a>
            </div>
            @endif
        </div>

        <!-- My Loans Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">My Loans</h2>
                <a href="{{ route('member.loans.apply') }}"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                    + Apply New Loan
                </a>
            </div>

            @php
                $userLoans = auth()->user()->loans()->orderBy('applied_date', 'desc')->get();
            @endphp

            @if($userLoans->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <div class="text-5xl mb-4 text-gray-400">📋</div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Loans Applied Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't applied for any loans yet.</p>
                    <a href="{{ route('member.loans.apply') }}"
                        class="inline-block px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for Your First Loan
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-300 bg-gray-50">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Loan Number</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Type</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Amount</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Applied Date</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Status</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($userLoans as $index => $loan)
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300">{{ $index + 1 }}</td>

                                    <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300">{{ $loan->loan_number }}</td>

                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <span class="px-2 py-1 text-xs font-medium rounded {{ $loan->loan_type === 'first_loan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $loan->loan_type === 'first_loan' ? 'First Loan' : 'Second Loan' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900 border-r border-gray-300">
                                        KES {{ number_format($loan->amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                        {{ $loan->applied_date->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 border-r border-gray-300">
                                        @if($loan->status === 'pending')
                                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                                Pending
                                            </span>
                                        @elseif($loan->status === 'approved')
                                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                                Approved
                                            </span>
                                        @elseif($loan->status === 'rejected')
                                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                                Rejected
                                            </span>
                                        @elseif($loan->status === 'disbursed' || $loan->status === 'active')
                                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="{{ route('member.loans.show', $loan->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition inline-flex items-center">
                                            View Details 
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-semibold text-blue-900 mb-6">Quick Actions</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('member.loans.apply') }}"
                    class="bg-white border border-blue-300 rounded-xl p-4 text-center hover:bg-blue-50 transition group">
                    <div class="text-3xl text-blue-600 mb-2">📝</div>
                    <h4 class="font-semibold text-blue-900 group-hover:text-blue-700">Apply for Loan</h4>
                    <p class="text-sm text-gray-600 mt-1">Get quick access to funds</p>
                </a>

                <a href="{{ route('member.savings.index') }}"
                    class="bg-white border border-green-300 rounded-xl p-4 text-center hover:bg-green-50 transition group">
                    <div class="text-3xl text-green-600 mb-2">💰</div>
                    <h4 class="font-semibold text-green-900 group-hover:text-green-700">View Savings</h4>
                    <p class="text-sm text-gray-600 mt-1">Check your savings balance</p>
                </a>

                <a href="{{ route('member.loans.index') }}"
                    class="bg-white border border-purple-300 rounded-xl p-4 text-center hover:bg-purple-50 transition group">
                    <div class="text-3xl text-purple-600 mb-2">📊</div>
                    <h4 class="font-semibold text-purple-900 group-hover:text-purple-700">Loan Statements</h4>
                    <p class="text-sm text-gray-600 mt-1">View loan repayment history</p>
                </a>
            </div>
        </div>

    </div>
@endsection