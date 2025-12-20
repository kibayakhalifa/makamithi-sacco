@extends('components.dashboard-layout')

@section('title', 'Loans Management')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-green-700 font-bold">📊</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Loans Management</h1>
                        <p class="text-gray-500 text-sm md:text-base">Manage loan applications, approvals, disbursements, and repayments</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Active Loan Portfolio</p>
                    <p class="text-3xl font-bold text-gray-900">KES {{ number_format($loanStats['total_amount'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $loanStats['total_loans'] }} total loans</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Loans</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['active_loans'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Being repaid</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">📈</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['pending_loans'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting approval</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Rejected</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['rejected_loans'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Not approved</p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg">
                    <span class="text-red-600 text-xl">❌</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Paid Off</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['paid_loans'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">Completed loans</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">✅</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('pending')" id="pendingTab"
                    class="px-6 py-4 font-medium border-b-2 border-orange-600 text-orange-700 whitespace-nowrap">
                    ⏳ Pending ({{ $loansByStatus['pending']->count() }})
                </button>
                <button onclick="switchTab('approved')" id="approvedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Approved ({{ $loansByStatus['approved']->count() }})
                </button>
                <button onclick="switchTab('active')" id="activeTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    📈 Active ({{ $loansByStatus['active']->count() }})
                </button>
                <button onclick="switchTab('rejected')" id="rejectedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ❌ Rejected ({{ $loansByStatus['rejected']->count() }})
                </button>
                <button onclick="switchTab('defaulted')" id="defaultedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ⚠️ Defaulted ({{ $loansByStatus['defaulted']->count() }})
                </button>
                <button onclick="switchTab('paid')" id="paidTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    🎉 Paid ({{ $loansByStatus['paid']->count() }})
                </button>
            </nav>
        </div>

        <!-- Pending Loans -->
        <div id="pendingContent" class="p-6">
            @if($loansByStatus['pending']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Applied Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['pending'] as $index => $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-xs">{{ $loan->purpose }}</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                                <p class="text-gray-500 text-xs">Savings: KES {{ number_format($loan->user->savings->available_savings ?? 0, 2) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>{{ $loan->created_at->format('d M Y') }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex flex-col gap-2">
                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full border border-orange-200 font-medium">
                                                Pending Approval
                                            </span>
                                            <a href="{{ route('treasurer.loans.view', $loan->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                View details →
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Loans</h3>
                    <p class="text-gray-500">All loan applications have been processed.</p>
                </div>
            @endif
        </div>

        <!-- Approved Loans -->
        <div id="approvedContent" class="p-6 hidden">
            @if($loansByStatus['approved']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Approved Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['approved'] as $index => $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-xs">5% interest • {{ $loan->period_months }} months</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>{{ $loan->approved_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">By {{ $loan->approvedBy->name ?? 'Committee' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('treasurer.payments') }}?loan={{ $loan->id }}"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Disburse
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Approved Loans</h3>
                    <p class="text-gray-500">No loans are currently approved for disbursement.</p>
                </div>
            @endif
        </div>

        <!-- Active Loans -->
        <div id="activeContent" class="p-6 hidden">
            @if($loansByStatus['active']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Balance</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Next Payment</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['active'] as $index => $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-sm">{{ $loan->purpose }}</p>
                                        <p class="text-gray-500 text-xs">KES {{ number_format($loan->monthly_payment, 2) }}/month</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES {{ number_format($loan->remaining_balance, 2) }}</p>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                            <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $loan->percentage_paid }}%"></div>
                                        </div>
                                        <p class="text-gray-500 text-xs mt-1">{{ number_format($loan->percentage_paid, 1) }}% paid</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>{{ $loan->next_payment_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">
                                                {{ $loan->next_payment_date ? $loan->next_payment_date->diffForHumans() : '' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="recordPayment({{ $loan->id }})"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Record Payment
                                            </button>
                                            <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
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
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Active Loans</h3>
                    <p class="text-gray-500">No loans are currently being repaid.</p>
                </div>
            @endif
        </div>

        <!-- Rejected Loans -->
        <div id="rejectedContent" class="p-6 hidden">
            @if($loansByStatus['rejected']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Rejected Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Reason</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['rejected'] as $index => $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-xs">{{ $loan->purpose }}</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>{{ $loan->rejected_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">By {{ $loan->rejectedBy->name ?? 'Committee' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="text-red-600 text-sm">{{ $loan->rejection_reason ?? 'No reason provided' }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('treasurer.loans.view', $loan->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                View details →
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Rejected Loans</h3>
                    <p class="text-gray-500">No loans have been rejected.</p>
                </div>
            @endif
        </div>

        <!-- Defaulted Loans -->
        <div id="defaultedContent" class="p-6 hidden">
            @if($loansByStatus['defaulted']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Arrears</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Days Late</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['defaulted'] as $index => $loan)
                                @php
                                    $daysLate = $loan->next_payment_date ? now()->diffInDays($loan->next_payment_date) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-sm">KES {{ number_format($loan->amount, 2) }}</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->phone ?? 'No phone' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-red-600">KES {{ number_format($loan->remaining_balance, 2) }}</p>
                                        <p class="text-gray-500 text-xs">Total arrears</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <p class="text-red-600 font-bold">{{ $daysLate }} days</p>
                                        <p class="text-gray-500 text-xs">Since {{ $loan->next_payment_date?->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <div class="flex gap-2">
                                            <button onclick="contactMember({{ $loan->user_id }})"
                                                class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Contact
                                            </button>
                                            <button onclick="initiateRecovery({{ $loan->id }})"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                Recover
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">🎉</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Defaulted Loans</h3>
                    <p class="text-gray-500">All members are up-to-date with payments.</p>
                </div>
            @endif
        </div>

        <!-- Paid Loans -->
        <div id="paidContent" class="p-6 hidden">
            @if($loansByStatus['paid']->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Loan Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Paid Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Total Paid</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loansByStatus['paid'] as $index => $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                        <p class="text-gray-500 text-sm">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-gray-500 text-xs">{{ $loan->period_months }} months</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-gray-700 text-sm font-medium">
                                                    {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">{{ $loan->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        <div>
                                            <p>{{ $loan->paid_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">Loan completed</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <p class="font-bold text-green-600">KES {{ number_format($loan->total_repayable, 2) }}</p>
                                        <p class="text-gray-500 text-xs">Incl. interest</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200 font-medium">
                                            Fully Paid
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Completed Loans</h3>
                    <p class="text-gray-500">Loan completion history will appear here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Loan Reports & Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Loan Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('arrears')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>⚠️ Loan Arrears Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('portfolio')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📊 Loan Portfolio Analysis</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('performance')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📈 Loan Performance Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportLoanData()"
                    class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center border border-green-200">
                    <span>💾 Export Loan Data (Excel)</span>
                    <span class="text-green-600">→</span>
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('member.loans.apply') }}"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>➕</span> New Loan Application
                </a>
                <button onclick="sendPaymentReminders()"
                    class="w-full bg-orange-50 hover:bg-orange-100 text-orange-800 py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📧</span> Send Payment Reminders
                </button>
                <button onclick="updateInterestRates()"
                    class="w-full bg-gray-50 hover:bg-gray-100 text-gray-800 py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📊</span> Update Interest Rates
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
        ['pending', 'approved', 'active', 'rejected', 'defaulted', 'paid'].forEach(tab => {
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

    // Updated recordPayment function with cheque number
function recordPayment(loanId) {
    // Create a custom modal for payment input
    const modalHtml = `
        <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl w-full max-w-md">
                <div class="p-4 border-b border-gray-300">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Record Loan Payment</h3>
                        <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                            ✕
                        </button>
                    </div>
                </div>
                
                <form id="paymentForm" class="p-4 space-y-4">
                    <input type="hidden" name="loan_id" value="${loanId}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount (KES)*</label>
                        <input type="number" name="amount" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter amount">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date*</label>
                        <input type="date" name="payment_date" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="${new Date().toISOString().split('T')[0]}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method*</label>
                        <select name="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            onchange="toggleChequeNumber(this.value)">
                            <option value="">Select method</option>
                            <option value="cash">Cash</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                            <option value="payroll">Payroll Deduction</option>
                        </select>
                    </div>
                    
                    <!-- Cheque Number Field (initially hidden) -->
                    <div id="chequeNumberField" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cheque Number*</label>
                        <input type="text" name="cheque_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter cheque number">
                    </div>
                    
                    <!-- Reference Number Field (for other methods) -->
                    <div id="referenceNumberField">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                        <input type="text" name="reference_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="M-Pesa code, bank ref, etc.">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Payment notes..."></textarea>
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closePaymentModal()"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit" id="submitPaymentBtn"
                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;

    // Remove existing modal if any
    const existingModal = document.getElementById('paymentModal');
    if (existingModal) {
        existingModal.remove();
    }

    // Add new modal
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    // Handle form submission
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitPayment(this, loanId);
    });
}

// Toggle cheque number field
function toggleChequeNumber(paymentMethod) {
    const chequeField = document.getElementById('chequeNumberField');
    const referenceField = document.getElementById('referenceNumberField');
    
    if (paymentMethod === 'cheque') {
        chequeField.classList.remove('hidden');
        // Make cheque number required
        chequeField.querySelector('input').required = true;
        // Hide reference number field
        referenceField.classList.add('hidden');
        // Clear reference number
        document.querySelector('input[name="reference_number"]').value = '';
    } else {
        chequeField.classList.add('hidden');
        // Remove required from cheque number
        chequeField.querySelector('input').required = false;
        // Clear cheque number
        document.querySelector('input[name="cheque_number"]').value = '';
        // Show reference number field
        referenceField.classList.remove('hidden');
        // Make reference optional for cash
        document.querySelector('input[name="reference_number"]').required = paymentMethod !== 'cash';
    }
}

// Close modal
function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.remove();
    }
}

// Submit payment
// Submit payment
async function submitPayment(form, loanId) {
    const submitBtn = document.getElementById('submitPaymentBtn');
    const originalText = submitBtn.innerHTML;
    
    // Disable button and show loading
    submitBtn.innerHTML = '<span class="animate-spin">⏳</span> Processing...';
    submitBtn.disabled = true;

    try {
        const formData = new FormData(form);
        
        // Check if cheque payment requires cheque number
        const paymentMethod = formData.get('payment_method');
        if (paymentMethod === 'cheque') {
            const chequeNumber = formData.get('cheque_number');
            if (!chequeNumber || chequeNumber.trim() === '') {
                alert('Please enter cheque number for cheque payments');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }
        }

        // Prepare data for controller
        const data = {
            _token: formData.get('_token'),
            amount: parseFloat(formData.get('amount')),
            payment_date: formData.get('payment_date'),
            payment_method: paymentMethod,
            notes: formData.get('notes'),
            cheque_number: formData.get('cheque_number'),
            reference_number: formData.get('reference_number')
        };

        // Remove empty values
        Object.keys(data).forEach(key => {
            if (data[key] === null || data[key] === undefined || data[key] === '') {
                delete data[key];
            }
        });

        console.log('Submitting payment:', data);

        // Use the correct route - match your Laravel route pattern
        // OPTION 1: Using the route name (requires meta tag for base URL)
        const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
        const url = `${baseUrl}/treasurer/loans/${loanId}/record-payment`;
        
        // OPTION 2: Hardcode with CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        // Send to controller
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || data._token,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const responseData = await response.json();

        if (!response.ok) {
            // Handle validation errors (422)
            if (response.status === 422 && responseData.errors) {
                const errors = Object.values(responseData.errors).flat().join('\n');
                throw new Error(errors);
            }
            throw new Error(responseData.message || `HTTP error! status: ${response.status}`);
        }

        if (responseData.success) {
            // Show success message
            alert(`✅ Payment recorded successfully!\nAmount: KES ${data.amount.toLocaleString()}\nNew Balance: KES ${responseData.new_balance?.toLocaleString() || 'N/A'}`);
            
            // Close modal
            closePaymentModal();
            
            // Reload page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } else {
            throw new Error(responseData.message || 'Payment failed');
        }

    } catch (error) {
        console.error('Payment error:', error);
        
        // Show specific error messages
        let errorMessage = error.message;
        if (error.message.includes('cheque_records.cheque_number')) {
            errorMessage = 'Cheque number already exists. Please use a unique cheque number.';
        } else if (error.message.includes('validation')) {
            errorMessage = 'Please check your input fields and try again.';
        }
        
        alert(`❌ Error: ${errorMessage}`);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}
    function contactMember(userId) {
        if (confirm('Open contact options for this member?')) {
            // Open contact modal or redirect
            window.location.href = `/members/${userId}/contact`;
        }
    }

    function initiateRecovery(loanId) {
        if (confirm('Initiate recovery process for this loan?')) {
            window.location.href = `/treasurer/loans/${loanId}/recovery`;
        }
    }

    function generateReport(type) {
        window.location.href = `/treasurer/reports/loans/${type}`;
    }

    function exportLoanData() {
        if (confirm('Export all loan data to Excel?')) {
            window.location.href = '/treasurer/loans/export';
        }
    }

    function sendPaymentReminders() {
        if (confirm('Send payment reminders to all members with upcoming payments?')) {
            fetch('/treasurer/loans/send-reminders', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment reminders sent successfully!');
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
        }
    }

    function updateInterestRates() {
        const newRate = prompt('Enter new interest rate (%):');
        if (newRate && !isNaN(newRate)) {
            if (confirm(`Update interest rate to ${newRate}% for all new loans?`)) {
                // AJAX call to update rates
                fetch('/treasurer/loans/update-rates', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ rate: newRate })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Interest rates updated successfully!');
                        } else {
                            alert('Error: ' + data.message);
                        }
                    });
            }
        }
    }

    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('pending');
    });
</script>
@endsection