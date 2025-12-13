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
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES {{ number_format($stats['total_savings'] ?? 0, 2) }}
                        </p>
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['active_loans_count'] ?? 0 }}</p>
                    </div>
                    <div class="text-3xl">📄</div>
                </div>
            </div>

            <!-- Loan Balance -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Loan Balance</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES {{ number_format($stats['total_loan_balance'] ?? 0, 2) }}
                        </p>
                    </div>
                    <div class="text-3xl">💸</div>
                </div>
            </div>

            <!-- Withdrawable Amount -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Withdrawable</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">
                            KES {{ number_format($stats['withdrawable_amount'] ?? 0, 2) }}
                        </p>
                    </div>
                    <div class="text-3xl">🏦</div>
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

            @if($recentTransactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date</th>
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
                                    <p class="font-medium text-gray-900">{{ $transaction->transaction_date?->format('d M Y') ?? $transaction->created_at->format('d M Y') }}</p>
                                    <p class="text-gray-500 text-xs">{{ $transaction->transaction_date?->diffForHumans() ?? $transaction->created_at->diffForHumans() }}</p>
                                </td>

                                <td class="px-6 py-4 font-semibold border-r border-gray-300 {{ $transaction->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->amount > 0 ? '+' : '' }}KES {{ number_format(abs($transaction->amount), 2) }}
                                </td>

                                <td class="px-6 py-4 border-r border-gray-300">
                                    <span class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span>
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
                                            ✗ {{ ucfirst($transaction->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <p class="text-gray-500">No transactions yet</p>
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
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No loans applied yet</p>
                    <a href="{{ route('member.loans.apply') }}"
                        class="inline-block mt-4 px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for a Loan Now
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

                                    <td class="px-6 py-4 text-gray-700 border-r border-gray-300">{{ $loan->loan_type ?? 'Standard' }}</td>

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
                                        @elseif($loan->status === 'disbursed')
                                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                                Disbursed
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full font-medium">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="{{ route('member.loans.show', $loan->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                            View Details →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Loans + Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Active Loans</h3>

                @if($activeLoans->count() > 0)
                <div class="space-y-4">
                    @foreach($activeLoans as $loan)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        KES {{ number_format($loan->remaining_balance, 2) }}
                                    </p>
                                    <p class="text-gray-500 text-xs">{{ $loan->loan_number }} • Applied: {{ $loan->applied_date->format('d M Y') }}</p>
                                </div>

                                <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full font-medium">
                                    Active
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No active loans</p>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                <div class="space-y-3">
                    <a href="{{ route('member.loans.apply') }}"
                        class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                        📝 Apply for a Loan
                    </a>

                    <a href="{{ route('member.savings.index') }}"
                        class="w-full flex items-center justify-center gap-2 bg-gray-700 text-white py-3 rounded-lg font-medium hover:bg-gray-600 transition">
                        💰 View Savings
                    </a>

                    <button
                        class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-800 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        📄 Download Statement
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection