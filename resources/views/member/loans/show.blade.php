@extends('components.dashboard-layout')

@section('title', 'Loan Details - ' . $loan->loan_number)

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $loan->loan_number }}</h1>
                            <div class="flex items-center gap-2 mt-1">
                                @if($loan->isFirstLoan())
                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">First Loan</span>
                                @elseif($loan->isSecondLoan())
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Second Loan</span>
                                @endif
                                
                                @if($loan->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">⏳ Pending</span>
                                @elseif($loan->status === 'approved')
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✅ Approved</span>
                                @elseif($loan->status === 'rejected')
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">❌ Rejected</span>
                                @elseif($loan->status === 'disbursed' || $loan->status === 'active')
                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">💸 Active</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $loan->purpose ?? 'General Purpose' }}</p>
                </div>
                <a href="{{ route('member.loans.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition text-sm">
                    ← Back to Loans
                </a>
            </div>
        </div>

        <!-- Loan Relationships -->
        @if($loan->isSecondLoan() && $loan->parentLoan)
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-lg">🔗</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-blue-900 mb-1">Connected to First Loan</h3>
                        <p class="text-sm text-blue-700">
                            This second loan is linked to your first loan: 
                            <a href="{{ route('member.loans.show', $loan->parentLoan->id) }}" 
                               class="font-medium underline hover:text-blue-900">
                                {{ $loan->parentLoan->loan_number }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($loan->isFirstLoan() && $loan->secondLoan)
            <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-600 text-lg">🔗</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-green-900 mb-1">Has Second Loan</h3>
                        <p class="text-sm text-green-700">
                            This first loan has an associated second loan: 
                            <a href="{{ route('member.loans.show', $loan->secondLoan->id) }}" 
                               class="font-medium underline hover:text-green-900">
                                {{ $loan->secondLoan->loan_number }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Loan Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Amount</p>
                        <p class="text-lg font-bold text-gray-900">KES {{ number_format($loan->amount, 0) }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Interest</p>
                        <p class="text-lg font-bold text-gray-900">{{ $loan->interest_rate }}%</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Total Payable</p>
                        <p class="text-lg font-bold text-gray-900">KES {{ number_format($loan->total_repayable, 0) }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Monthly</p>
                        <p class="text-lg font-bold text-gray-900">KES {{ number_format($loan->monthly_payment, 0) }}</p>
                    </div>
                </div>

                <!-- Progress & Payment -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Payment Progress</h2>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Paid: <span class="font-bold">KES {{ number_format($loan->amount_paid, 0) }}</span></p>
                            <p class="text-sm text-gray-600">Balance: <span class="font-bold">KES {{ number_format($remainingBalance, 0) }}</span></p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ number_format($percentagePaid, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="{{ $loan->isFirstLoan() ? 'bg-blue-600' : 'bg-green-600' }} h-2 rounded-full" style="width: {{ min($percentagePaid, 100) }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>{{ $loan->months_paid }} months paid</span>
                            <span>{{ $loan->months_remaining }} months remaining</span>
                        </div>
                    </div>

                    <!-- Next Payment -->
                    @if($loan->status === 'active' || $loan->status === 'disbursed')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-blue-800 font-medium">Next Payment Due</p>
                                <p class="text-2xl font-bold text-blue-900 mt-1">KES {{ number_format($loan->monthly_payment, 0) }}</p>
                                <p class="text-sm text-blue-600 mt-1">Due on {{ $loan->next_payment_date?->format('d M Y') ?? 'Not set' }}</p>
                            </div>
                            <a href="{{ route('member.payments.create', $loan->id) }}"
                                class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-sm">
                                Make Payment
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- In your loan details view, replace the payment schedule section with: -->
                                <!-- SIMPLE PAYMENT SCHEDULE -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Payment Schedule</h2>
                                <p class="text-sm text-gray-500">{{ $loan->period_months }} monthly installments</p>
                            </div>
                            <a href="{{ route('member.loans.print-schedule', $loan) }}" target="_blank"
                            class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 text-sm">
                                🖨️ Print
                            </a>
                        </div>
                    </div>

                    <!-- Quick Summary -->
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <div class="text-gray-600">Monthly Payment</div>
                                <div class="font-semibold">KES {{ number_format($loan->monthly_payment, 0) }}</div>
                            </div>
                            <div>
                                <div class="text-gray-600">Remaining</div>
                                <div class="font-semibold">KES {{ number_format($loan->remaining_balance, 0) }}</div>
                            </div>
                            <div>
                                <div class="text-gray-600">Months Left</div>
                                <div class="font-semibold">{{ $loan->period_months - $loan->months_paid }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- The Simple Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Due Date</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Amount</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Balance After</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php
                                    // SIMPLE CALCULATION
                                    $remainingBalance = $loan->remaining_balance;
                                    $monthsPaid = $loan->months_paid;
                                    $totalMonths = $loan->period_months;
                                    
                                    // What each future payment should be
                                    $remainingMonths = max(1, $totalMonths - $monthsPaid);
                                    $futurePayment = $remainingMonths > 0 ? ceil($remainingBalance / $remainingMonths) : 0;
                                    
                                    $startDate = $loan->disbursed_date ? \Carbon\Carbon::parse($loan->disbursed_date) : now();
                                @endphp
                                
                                @for($i = 1; $i <= $totalMonths; $i++)
                                    @php
                                        $dueDate = $startDate->copy()->addMonths($i);
                                        $isPaid = $i <= $monthsPaid;
                                        $isNext = $i == $monthsPaid + 1;
                                        $isPastDue = !$isPaid && $dueDate < now();
                                        
                                        // Amount for this installment
                                        $amount = $isPaid ? $loan->monthly_payment : $futurePayment;
                                        
                                        // Calculate balance after this payment
                                        if ($isPaid) {
                                            // Already paid - balance was reduced
                                            $balanceAfter = $remainingBalance + $amount; // Add back to show correctly
                                        } else {
                                            // Future payment - reduce balance
                                            $balanceAfter = max(0, $remainingBalance - $amount);
                                        }
                                    @endphp
                                    
                                    <tr class="{{ $isNext ? 'bg-blue-50' : '' }} hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $i }}
                                            @if($isNext)<span class="text-xs text-blue-600 ml-1">→</span>@endif
                                        </td>
                                        
                                        <td class="px-4 py-3">
                                            <div>{{ $dueDate->format('d M Y') }}</div>
                                            @if($isNext)
                                            <div class="text-xs text-blue-600 font-medium">Next Payment</div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-3 font-medium">
                                            <div>KES {{ number_format($amount, 0) }}</div>
                                            @if(!$isPaid && $amount != $loan->monthly_payment)
                                            <div class="text-xs text-gray-500">
                                                <span class="line-through">KES {{ number_format($loan->monthly_payment, 0) }}</span>
                                                <span class="text-green-600 ml-1">↓ Reduced</span>
                                            </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-3">
                                            @if($isPaid)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">✓ Paid</span>
                                            @elseif($isNext)
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Due</span>
                                            @elseif($isPastDue)
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Overdue</span>
                                            @else
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">Pending</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-3 font-medium">
                                            KES {{ number_format($balanceAfter, 0) }}
                                        </td>
                                    </tr>
                                    
                                    @php
                                        // Update running balance for next row
                                        $remainingBalance = $balanceAfter;
                                    @endphp
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Simple Legend -->
                    <div class="px-6 py-3 bg-gray-50 border-t text-sm text-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-100 border border-green-300 rounded-full"></div>
                                <span>Paid</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-100 border border-blue-300 rounded-full"></div>
                                <span>Next Payment</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-gray-100 border border-gray-300 rounded-full"></div>
                                <span>Future Payments</span>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Timeline Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-md font-semibold text-gray-900 mb-4">Loan Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-6 w-6 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 text-xs">✓</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Applied</p>
                                <p class="text-xs text-gray-500">{{ $loan->applied_date->format('d M Y') }}</p>
                            </div>
                        </div>

                        @if($loan->approved_date)
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 text-xs">✓</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Approved</p>
                                <p class="text-xs text-gray-500">{{ $loan->approved_date->format('d M Y') }}</p>
                                @if($loan->approver)
                                <p class="text-xs text-gray-600 mt-0.5">By: {{ $loan->approver->name }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($loan->disbursed_date)
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-6 w-6 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-purple-600 text-xs">$</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Disbursed</p>
                                <p class="text-xs text-gray-500">{{ $loan->disbursed_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($loan->expected_completion_date)
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-600 text-xs">⏱</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Expected Completion</p>
                                <p class="text-xs text-gray-500">{{ $loan->expected_completion_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status & Documents -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
                    @if($loan->status === 'rejected' && $loan->rejection_reason)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <h4 class="text-sm font-semibold text-red-900 mb-1">Rejection Reason</h4>
                        <p class="text-xs text-red-700">{{ $loan->rejection_reason }}</p>
                    </div>
                    @endif

                    @if($loan->support_document)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Support Document</h4>
                        <a href="{{ asset('storage/' . $loan->support_document) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition text-sm">
                            <span>📄</span>
                            View Document
                        </a>
                    </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Loan Period:</span>
                            <span class="font-medium text-gray-900">{{ $loan->period_months }} months</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Payments Made:</span>
                            <span class="font-medium text-gray-900">{{ $loan->months_paid }}/{{ $loan->period_months }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Days to Complete:</span>
                            @if($loan->expected_completion_date)
                            <span class="font-medium text-gray-900">{{ max(0, $loan->expected_completion_date->diffInDays(now())) }} days</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(($loan->status === 'active' || $loan->status === 'disbursed') && $remainingBalance > 0)
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('member.payments.create', $loan->id) }}"
                            class="block w-full text-center px-4 py-2.5 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition text-sm">
                            Make Payment
                        </a>
                        @if($remainingBalance > 0)
                        <button onclick="showEarlyRepaymentModal()"
                            class="block w-full text-center px-4 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-sm">
                            Early Full Repayment
                        </button>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Second Loan Eligibility -->
                @if($loan->isFirstLoan() && $loan->status === 'active' && !$loan->secondLoan)
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                    <h4 class="text-sm font-semibold text-yellow-900 mb-2">Second Loan Eligibility</h4>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-yellow-800 mb-1">
                            <span>Progress to qualify:</span>
                            <span>{{ number_format($loan->percentage_paid, 1) }}/50%</span>
                        </div>
                        <div class="w-full bg-yellow-200 rounded-full h-1.5">
                            <div class="bg-yellow-600 h-1.5 rounded-full" style="width: {{ min($loan->percentage_paid, 50) * 2 }}%"></div>
                        </div>
                    </div>
                    @if($loan->percentage_paid >= 50)
                    <a href="{{ route('member.loans.apply') }}"
                        class="block w-full text-center px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition text-sm">
                        Apply for Second Loan
                    </a>
                    @else
                    <p class="text-xs text-yellow-700">
                        Need {{ number_format(50 - $loan->percentage_paid, 1) }}% more to qualify for a second loan.
                    </p>
                    @endif
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Early Repayment Modal -->
    @if(($loan->status === 'active' || $loan->status === 'disbursed') && $remainingBalance > 0)
    <div id="earlyRepaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Early Full Repayment</h3>
                <p class="text-sm text-gray-600 mb-4">
                    You're about to pay off your entire remaining balance of 
                    <strong>KES {{ number_format($remainingBalance, 0) }}</strong>.
                    This will close your loan account.
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-yellow-800">
                        <strong>Note:</strong> Early repayment may affect future loan eligibility.
                    </p>
                </div>
                <form id="earlyRepaymentForm" action="{{ route('member.loans.early-repayment', $loan->id) }}" method="POST">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="hideEarlyRepaymentModal()"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-sm">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-sm">
                            Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showEarlyRepaymentModal() {
            document.getElementById('earlyRepaymentModal').classList.remove('hidden');
        }
        function hideEarlyRepaymentModal() {
            document.getElementById('earlyRepaymentModal').classList.add('hidden');
        }
        document.getElementById('earlyRepaymentModal').addEventListener('click', function(e) {
            if (e.target === this) hideEarlyRepaymentModal();
        });
    </script>
    @endif
@endsection