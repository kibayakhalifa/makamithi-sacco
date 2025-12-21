@extends('components.dashboard-layout')

@section('title', 'My Payments & Disbursements')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-green-700 font-bold">💳</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Payments & Disbursements</h1>
                        <p class="text-gray-500 text-sm md:text-base">View all payments, disbursements, and transaction details</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Total Received</p>
                    <p class="text-3xl font-bold text-gray-900">KES {{ number_format($stats['total_received'], 2) }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $payments->total() }} transactions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Loan Disbursements -->
        <div class="bg-white border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-blue-800 text-xs uppercase tracking-wider font-medium">Loan Disbursements</h3>
                    <p class="text-2xl font-bold text-blue-900 mt-2">KES {{ number_format($stats['loan_disbursements'], 2) }}</p>
                    <p class="text-blue-700 text-sm mt-1">{{ $paymentsByType['loan_disbursement'] }} disbursements</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">🏦</span>
                </div>
            </div>
        </div>

        <!-- Savings Withdrawals -->
        <div class="bg-white border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-green-800 text-xs uppercase tracking-wider font-medium">Savings Withdrawals</h3>
                    <p class="text-2xl font-bold text-green-900 mt-2">KES {{ number_format($stats['savings_withdrawals'], 2) }}</p>
                    <p class="text-green-700 text-sm mt-1">{{ $paymentsByType['savings_withdrawal'] }} withdrawals</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">💰</span>
                </div>
            </div>
        </div>

        <!-- Cheque Payments -->
        <div class="bg-white border border-purple-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-purple-800 text-xs uppercase tracking-wider font-medium">Cheque Payments</h3>
                    <p class="text-2xl font-bold text-purple-900 mt-2">{{ $stats['total_cheques'] }}</p>
                    <p class="text-purple-700 text-sm mt-1">Total cheque transactions</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">📄</span>
                </div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white border border-orange-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-orange-800 text-xs uppercase tracking-wider font-medium">Pending</h3>
                    <p class="text-2xl font-bold text-orange-900 mt-2">{{ $stats['pending_payments'] }}</p>
                    <p class="text-orange-700 text-sm mt-1">Awaiting processing</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('allPayments')" id="allPaymentsTab"
                    class="px-4 py-3 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap text-sm">
                    📋 All Payments
                </button>
                <button onclick="switchTab('loanDisbursements')" id="loanDisbursementsTab"
                    class="px-4 py-3 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-sm">
                    🏦 Loan Disbursements
                </button>
                <button onclick="switchTab('savingsWithdrawals')" id="savingsWithdrawalsTab"
                    class="px-4 py-3 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-sm">
                    💰 Savings Withdrawals
                </button>
                <button onclick="switchTab('chequePayments')" id="chequePaymentsTab"
                    class="px-4 py-3 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-sm">
                    📄 Cheque Payments
                </button>
            </nav>
        </div>

        <!-- All Payments Tab -->
        <div id="allPaymentsContent" class="p-4">
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">All Payment History</h3>
                <div class="text-sm text-gray-500">
                    Showing {{ $payments->firstItem() }}-{{ $payments->lastItem() }} of {{ $payments->total() }} payments
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Reference</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->payment_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->payment_ref }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    @if($payment->loan)
                                        @if($payment->amount == $payment->loan->loan_amount)
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Loan Disbursement</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Loan Repayment Refund</span>
                                        @endif
                                    @elseif($payment->savingsTransaction)
                                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Savings Withdrawal</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Other Payment</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-gray-900">
                                    KES {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <span class="capitalize">{{ $payment->payment_method }}</span>
                                        @if($payment->payment_method === 'cheque' && isset($chequeDetails[$payment->id]))
                                            <span class="text-xs text-gray-500">({{ $chequeDetails[$payment->id]->cheque_number }})</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium 
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <a href="{{ route('member.payment.show', $payment->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <span class="text-3xl mb-2">💳</span>
                                        <p class="text-lg">No payments found</p>
                                        <p class="text-sm">You haven't received any payments yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

        <!-- Loan Disbursements Tab -->
        <div id="loanDisbursementsContent" class="p-4 hidden">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Loan Disbursements</h3>
                <p class="text-gray-500 text-sm">Funds received as loan disbursements</p>
            </div>

            <div class="space-y-4">
                @forelse($loanDisbursements as $disbursement)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-blue-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <span class="text-blue-600 font-bold">🏦</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">Loan #{{ $disbursement->loan->loan_number }}</p>
                                        <p class="text-gray-600 text-sm">{{ $disbursement->loan->purpose }}</p>
                                    </div>
                                </div>
                                <div class="ml-13">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Disbursed:</span> 
                                        {{ $disbursement->payment_date->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Method:</span> 
                                        {{ ucfirst($disbursement->payment_method) }}
                                        @if($disbursement->payment_method === 'cheque' && $disbursement->reference_number)
                                            (Cheque: {{ $disbursement->reference_number }})
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-700">KES {{ number_format($disbursement->amount, 2) }}</p>
                                <p class="text-sm text-gray-500 mt-1">Full loan amount</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-3xl mb-2">🏦</span>
                        <p>No loan disbursements found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Savings Withdrawals Tab -->
        <div id="savingsWithdrawalsContent" class="p-4 hidden">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Savings Withdrawals</h3>
                <p class="text-gray-500 text-sm">Funds withdrawn from your savings account</p>
            </div>

            <div class="space-y-4">
                @forelse($savingsWithdrawals as $withdrawal)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-green-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <span class="text-green-600 font-bold">💰</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">Savings Withdrawal</p>
                                        <p class="text-gray-600 text-sm">Ref: {{ $withdrawal->transaction_ref }}</p>
                                    </div>
                                </div>
                                <div class="ml-13">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Date:</span> 
                                        {{ $withdrawal->transaction_date->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Processed by:</span> 
                                        {{ $withdrawal->processedBy->name ?? 'System' }}
                                    </p>
                                    @if($withdrawal->payment)
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Payment Method:</span> 
                                            {{ ucfirst($withdrawal->payment->payment_method) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-700">KES {{ number_format($withdrawal->amount, 2) }}</p>
                                <p class="text-sm text-gray-500 mt-1">Available balance increased</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-3xl mb-2">💰</span>
                        <p>No savings withdrawals found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cheque Payments Tab -->
        <div id="chequePaymentsContent" class="p-4 hidden">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Cheque Payments</h3>
                <p class="text-gray-500 text-sm">Payments received via cheque with detailed cheque information</p>
            </div>

            <div class="space-y-4">
                @php
                    $chequePayments = $chequeDetails->filter(function($cheque) {
                        return $cheque->payment;
                    });
                @endphp

                @forelse($chequePayments as $cheque)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-purple-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <span class="text-purple-600 font-bold">📄</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">Cheque #{{ $cheque->cheque_number }}</p>
                                        <p class="text-gray-600 text-sm capitalize">{{ str_replace('_', ' ', $cheque->purpose) }}</p>
                                    </div>
                                </div>
                                <div class="ml-13 space-y-1">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Bank:</span> {{ $cheque->bank_name }} ({{ $cheque->bank_branch }})
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Issued:</span> 
                                        {{ $cheque->issue_date->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Status:</span> 
                                        <span class="px-2 py-0.5 text-xs rounded-full 
                                            {{ $cheque->status === 'cleared' ? 'bg-green-100 text-green-800' : 
                                               ($cheque->status === 'issued' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($cheque->status) }}
                                        </span>
                                    </p>
                                    @if($cheque->clearance_date)
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Cleared:</span> 
                                            {{ $cheque->clearance_date->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-purple-700">KES {{ number_format($cheque->amount, 2) }}</p>
                                <p class="text-sm text-gray-500 mt-1">Cheque Amount</p>
                                @if($cheque->payment)
                                    <p class="text-xs text-gray-400 mt-2">
                                        Ref: {{ $cheque->payment->payment_ref }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-3xl mb-2">📄</span>
                        <p>No cheque payments found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Payments Received:</span>
                    <span class="font-bold text-gray-900">{{ $payments->total() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Loan Disbursements:</span>
                    <span class="font-medium text-blue-600">{{ $paymentsByType['loan_disbursement'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Savings Withdrawals:</span>
                    <span class="font-medium text-green-600">{{ $paymentsByType['savings_withdrawal'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Other Payments:</span>
                    <span class="font-medium text-gray-600">{{ $paymentsByType['other'] }}</span>
                </div>
                <div class="pt-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total Amount Received:</span>
                        <span class="text-xl font-bold text-green-700">KES {{ number_format($stats['total_received'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h3>
            <div class="space-y-4">
                @php
                    $paymentMethods = \App\Models\Payment::where('user_id', $user->id)
                        ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                        ->groupBy('payment_method')
                        ->get();
                @endphp

                @foreach($paymentMethods as $method)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 capitalize">{{ $method->payment_method }}:</span>
                            <span class="font-medium text-gray-900">{{ $method->count }} payments</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ ($method->count / max($payments->total(), 1)) * 100 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">KES {{ number_format($method->total, 2) }} total</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    // Tab switching function
    function switchTab(tabName) {
        // Hide all content
        ['allPayments', 'loanDisbursements', 'savingsWithdrawals', 'chequePayments'].forEach(tab => {
            const content = document.getElementById(tab + 'Content');
            const tabBtn = document.getElementById(tab + 'Tab');
            if (content) content.classList.add('hidden');
            if (tabBtn) {
                tabBtn.classList.remove('border-b-2', 'border-blue-600', 'text-blue-700');
                tabBtn.classList.add('text-gray-500');
            }
        });

        // Show selected content
        const selectedContent = document.getElementById(tabName + 'Content');
        const selectedTab = document.getElementById(tabName + 'Tab');

        if (selectedContent) {
            selectedContent.classList.remove('hidden');
        }
        if (selectedTab) {
            selectedTab.classList.add('border-b-2', 'border-blue-600', 'text-blue-700');
            selectedTab.classList.remove('text-gray-500');
        }
    }

    // Initialize with first tab
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('allPayments');
    });
</script>
@endsection