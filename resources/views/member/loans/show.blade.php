@extends('components.dashboard-layout')

@section('title', 'Loan Details - ' . $loan->loan_number)

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">{{ $loan->loan_number }}</h1>
                    <p class="text-gray-500 mt-1">Loan details and payment history</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Status</p>
                    @if ($loan->status === 'pending')
                        <span
                            class="px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-700 rounded-full inline-block mt-1">
                            ⏳ Pending Review
                        </span>
                    @elseif ($loan->status === 'approved')
                        <span
                            class="px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full inline-block mt-1">
                            ✅ Approved
                        </span>
                    @elseif ($loan->status === 'rejected')
                        <span class="px-3 py-1 text-sm font-semibold bg-red-100 text-red-700 rounded-full inline-block mt-1">
                            ❌ Rejected
                        </span>
                    @elseif ($loan->status === 'disbursed')
                        <span class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-700 rounded-full inline-block mt-1">
                            💸 Disbursed
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Loan Overview -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Loan Overview</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Loan Amount</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES {{ number_format($loan->amount, 2) }}</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Interest Rate</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $loan->interest_rate }}%</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Total Repayable</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES
                                {{ number_format($loan->total_repayable, 2) }}</p>
                        </div>
                        <div class="p-3 border border-gray-200 rounded bg-gray-50">
                            <p class="text-sm text-gray-500 font-medium">Monthly Payment</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">KES
                                {{ number_format($loan->monthly_payment, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Timeline</h2>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <span class="text-green-600 text-xl">📝</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Applied</p>
                                <p class="text-sm text-gray-500">{{ $loan->applied_date->format('d M Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        @if ($loan->approved_date)
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                                        <span class="text-blue-600 text-xl">✅</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Approved</p>
                                    <p class="text-sm text-gray-500">{{ $loan->approved_date->format('d M Y \a\t H:i') }}</p>
                                    @if ($loan->approver)
                                        <p class="text-sm text-gray-600 mt-1">By: <strong>{{ $loan->approver->name }}</strong>
                                            ({{ ucfirst($loan->approver->role) }})</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($loan->status === 'rejected' && $loan->rejection_reason)
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                        <span class="text-red-600 text-xl">❌</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Rejected</p>
                                    <p class="text-sm text-gray-500">{{ $loan->approved_date?->format('d M Y \a\t H:i') }}</p>
                                    <p class="text-sm text-red-600 mt-1">Reason: {{ $loan->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($loan->disbursed_date)
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                                        <span class="text-purple-600 text-xl">💸</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Disbursed</p>
                                    <p class="text-sm text-gray-500">{{ $loan->disbursed_date->format('d M Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($loan->support_document)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Support Document</h2>
                        <p class="text-sm text-gray-700">Uploaded document to support your application.</p>
                        <p class="mt-3">
                            <a href="{{ asset('storage/' . $loan->support_document) }}" target="_blank"
                                class="text-blue-600 hover:underline">Open document</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Schedule -->
        @if ($loan->status !== 'rejected')
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Schedule</h2>

                <div class="space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount Paid:</span>
                        <span class="font-semibold text-gray-900">KES {{ number_format($loan->amount_paid, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Remaining Balance:</span>
                        <span class="font-semibold text-gray-900">KES {{ number_format($remainingBalance, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Progress:</span>
                        <span class="font-semibold text-gray-900">{{ number_format($percentagePaid, 1) }}%</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($percentagePaid, 100) }}%"></div>
                </div>

                @if ($loan->payments && $loan->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse" style="border:1px solid #e5e7eb;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Date</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium border border-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loan->payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-gray-900 border border-gray-200">
                                            {{ $payment->payment_date->format('d M Y') }}</td>
                                        <td class="px-4 py-2 font-semibold text-gray-900 border border-gray-200">KES
                                            {{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-4 py-2 border border-gray-200">
                                            @if ($payment->status === 'completed')
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">✓
                                                    Completed</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded">{{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-6">No payments recorded yet</p>
                @endif
            </div>
        @endif

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">

        <!-- Summary Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Summary</h3>

            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-blue-800">Loan Period:</span>
                    <p class="font-semibold text-blue-900">{{ $loan->period_months }} months</p>
                </div>
                <div>
                    <span class="text-blue-800">Expected Completion:</span>
                    <p class="font-semibold text-blue-900">{{ $loan->expected_completion_date->format('d M Y') }}</p>
                </div>
                <div class="pt-3 border-t border-blue-200">
                    <span class="text-blue-800">Payments Completed:</span>
                    <p class="font-semibold text-blue-900">{{ $loan->months_paid }} / {{ $loan->period_months }} months</p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        @if ($loan->status === 'approved' && !$loan->disbursed_date)
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">⏳ Awaiting Disbursement</h3>
                <p class="text-sm text-yellow-800">Your loan has been approved. The Treasurer will process the disbursement
                    shortly.</p>
            </div>
        @elseif ($loan->status === 'pending')
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">📋 Under Review</h3>
                <p class="text-sm text-blue-800">Your application is being reviewed. You'll be notified once a decision is made.
                </p>
            </div>
        @elseif ($loan->status === 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-2">❌ Application Rejected</h3>
                <p class="text-sm text-red-800">
                    {{ $loan->rejection_reason ?? 'Your application could not be approved at this time.' }}</p>
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('member.loans.index') }}"
            class="block text-center px-4 py-3 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
            ← Back to Loans
        </a>

    </div>

    </div>

    </div>
@endsection