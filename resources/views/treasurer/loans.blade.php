@extends('components.dashboard-layout')

@section('title', 'Loans Management')

@section('content')
    <div class="space-y-6 font-sans">

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-lg">2</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Loans Management</h1>
                    </div>
                    <p class="text-green-800">Manage all loan applications, approvals, disbursements, and repayments</p>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                        <p class="text-green-600 text-sm font-medium">Active Loan Portfolio</p>
                        <p class="text-4xl font-bold text-gray-900">KES {{ number_format($loanStats['total_amount'], 2) }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1">{{ $loanStats['total_loans'] }} total loans</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Loans</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['active_loans'] }}</p>
                        <p class="text-gray-500 text-sm mt-1">Being repaid</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-xl">
                        <span class="text-green-600 text-xl">📈</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['pending_loans'] }}</p>
                        <p class="text-gray-500 text-sm mt-1">Awaiting approval</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-xl">
                        <span class="text-orange-600 text-xl">⏳</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Rejected</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['rejected_loans'] }}</p>
                        <p class="text-gray-500 text-sm mt-1">Not approved</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-xl">
                        <span class="text-red-600 text-xl">❌</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Paid Off</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $loanStats['paid_loans'] }}</p>
                        <p class="text-gray-500 text-sm mt-1">Completed loans</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-xl">
                        <span class="text-blue-600 text-xl">✅</span>
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
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        #</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Loan Details</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Member</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Applied Date</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['pending'] as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                            <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->purpose }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                    <span
                                                        class="text-gray-700 font-medium">{{ strtoupper(substr($loan->user->name, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                                    <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                                    <p class="text-gray-500 text-xs">Savings: KES
                                                        {{ number_format($loan->user->savings->available_savings ?? 0, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-gray-900">{{ $loan->created_at->format('d M Y') }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <span
                                                class="px-3 py-1 bg-orange-100 text-orange-800 text-xs rounded-full font-medium">Pending
                                                Approval</span>
                                            <div class="mt-2">
                                                <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                    class="inline-block mt-1 text-sm text-blue-600 hover:underline">View</a>
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Loans</h3>
                        <p class="text-gray-500">All loan applications have been processed.</p>
                    </div>
                @endif
            </div>

            <!-- Approved Loans -->
            <div id="approvedContent" class="p-6 hidden">
                @if($loansByStatus['approved']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        #</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Loan Details</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Member</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Approved Date</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['approved'] as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                            <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-xs">5% interest • {{ $loan->period_months }} months</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-gray-900">{{ $loan->approved_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">By {{ $loan->approvedBy->name ?? 'Committee' }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <div class="flex gap-2">
                                                <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">View</a>
                                                <a href="{{ route('treasurer.payments') }}?loan={{ $loan->id }}"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Disburse</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">📋</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Approved Loans</h3>
                        <p class="text-gray-500">No loans are currently approved for disbursement.</p>
                    </div>
                @endif
            </div>

            <!-- Active Loans -->
            <div id="activeContent" class="p-6 hidden">
                @if($loansByStatus['active']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        #</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Loan Details</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Member</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Balance</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Next Payment</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['active'] as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->purpose }}</p>
                                            <p class="text-gray-500 text-xs">KES
                                                {{ number_format($loan->monthly_payment, 2) }}/month
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">KES {{ number_format($loan->remaining_balance, 2) }}
                                            </p>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                                <div class="bg-green-600 h-2 rounded-full"
                                                    style="width: {{ $loan->percentage_paid }}%"></div>
                                            </div>
                                            <p class="text-gray-500 text-xs mt-1">{{ number_format($loan->percentage_paid, 1) }}%
                                                paid</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-gray-900">{{ $loan->next_payment_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">
                                                {{ $loan->next_payment_date ? $loan->next_payment_date->diffForHumans() : '' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <div class="flex gap-2">
                                                <button onclick="recordPayment({{ $loan->id }})"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                    Record Payment
                                                </button>
                                                <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">📊</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Active Loans</h3>
                        <p class="text-gray-500">No loans are currently being repaid.</p>
                    </div>
                @endif
            </div>

            <!-- Rejected Loans -->
            <div id="rejectedContent" class="p-6 hidden">
                @if($loansByStatus['rejected']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        #</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Loan Details</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Member</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Rejected Date</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['rejected'] as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                            <p class="text-gray-500 text-sm">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->purpose }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-gray-900">{{ $loan->rejected_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">By {{ $loan->rejectedBy->name ?? 'Committee' }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-red-600 text-sm">{{ $loan->rejection_reason ?? 'No reason provided' }}
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('treasurer.loans.view', $loan->id) }}"
                                                    class="inline-block mt-1 text-sm text-blue-600 hover:underline">View</a>
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Rejected Loans</h3>
                        <p class="text-gray-500">No loans have been rejected.</p>
                    </div>
                @endif
            </div>

            <!-- Defaulted Loans -->
            <div id="defaultedContent" class="p-6 hidden">
                @if($loansByStatus['defaulted']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Loan
                                        Details</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Member</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Arrears</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Days
                                        Late</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['defaulted'] as $loan)
                                    @php
                                        $daysLate = $loan->next_payment_date ? now()->diffInDays($loan->next_payment_date) : 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-sm">KES {{ number_format($loan->amount, 2) }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->user->phone ?? 'No phone' }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-red-600">KES {{ number_format($loan->remaining_balance, 2) }}
                                            </p>
                                            <p class="text-gray-500 text-xs">Total arrears</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="text-red-600 font-bold">{{ $daysLate }} days</p>
                                            <p class="text-gray-500 text-xs">Since {{ $loan->next_payment_date?->format('d M Y') }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex gap-2">
                                                <button onclick="contactMember({{ $loan->user_id }})"
                                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                    Contact
                                                </button>
                                                <button onclick="initiateRecovery({{ $loan->id }})"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
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
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">🎉</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Defaulted Loans</h3>
                        <p class="text-gray-500">All members are up-to-date with payments.</p>
                    </div>
                @endif
            </div>

            <!-- Paid Loans -->
            <div id="paidContent" class="p-6 hidden">
                @if($loansByStatus['paid']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        #</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Loan Details</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Member</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Paid Date</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Total Paid</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase border border-gray-200">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loansByStatus['paid'] as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-gray-900">#{{ $loan->loan_number }}</p>
                                            <p class="text-gray-500 text-sm">KES {{ number_format($loan->amount, 2) }}</p>
                                            <p class="text-gray-500 text-xs">{{ $loan->period_months }} months</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="text-gray-900">{{ $loan->paid_date?->format('d M Y') ?? 'N/A' }}</p>
                                            <p class="text-gray-500 text-xs">Loan completed</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <p class="font-bold text-green-600">KES {{ number_format($loan->total_repayable, 2) }}
                                            </p>
                                            <p class="text-gray-500 text-xs">Incl. interest</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200">
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Fully
                                                Paid</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4">📊</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Completed Loans</h3>
                        <p class="text-gray-500">Loan completion history will appear here.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Loan Reports -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Loan Reports</h3>
                <div class="space-y-3">
                    <button onclick="generateReport('arrears')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>⚠️ Loan Arrears Report</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="generateReport('portfolio')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>📊 Loan Portfolio Analysis</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="generateReport('performance')"
                        class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center">
                        <span>📈 Loan Performance Report</span>
                        <span class="text-gray-400">→</span>
                    </button>
                    <button onclick="exportLoanData()"
                        class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center">
                        <span>💾 Export Loan Data (Excel)</span>
                        <span class="text-green-600">→</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('member.loans.apply') }}"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                        <span>➕</span> New Loan Application
                    </a>
                    <button onclick="sendPaymentReminders()"
                        class="w-full bg-orange-50 hover:bg-orange-100 text-orange-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2">
                        <span>📧</span> Send Payment Reminders
                    </button>
                    <button onclick="updateInterestRates()"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-xl font-medium flex items-center justify-center gap-2">
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

        // Action functions
        function recordPayment(loanId) {
            const amount = prompt('Enter payment amount (KES):');
            if (amount && !isNaN(amount)) {
                // Show loading
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = 'Processing...';
                button.disabled = true;

                // Use the correct route - match what's in your route list
                fetch(`/treasurer/loans/${loanId}/payment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: parseFloat(amount),
                        payment_date: new Date().toISOString().split('T')[0],
                        payment_method: 'cash',
                        notes: 'Payment recorded via treasurer dashboard'
                    })
                })
                    .then(response => {
                        // Check if response is OK
                        if (response.status === 422) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Validation error');
                            });
                        }
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('✅ Payment recorded successfully!');
                            // Reload the page to see updated balance
                            location.reload();
                        } else {
                            alert('❌ Error: ' + (data.message || 'Unknown error'));
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        alert('❌ Error: ' + error.message);
                        console.error('Payment error:', error);
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
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
        document.addEventListener('DOMContentLoaded', function () {
            switchTab('pending');
        });
    </script>
@endsection