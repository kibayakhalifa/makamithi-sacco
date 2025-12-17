@extends('components.dashboard-layout')

@section('title', 'My Loans')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">My Loans</h1>
                    <p class="text-gray-500 mt-1">Manage and track your loan applications</p>
                </div>
                <a href="{{ route('member.loans.apply') }}"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    + Apply New Loan
                </a>
            </div>
        </div>

        <!-- Loan Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $user = auth()->user();
                $activeLoansCount = $loans->whereIn('status', ['active', 'disbursed', 'approved'])->count();
                
                // Query first loan directly
                $firstLoan = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->where('loan_type', 'first_loan')
                    ->first();
                
                // Query second loan directly
                $secondLoan = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->where('loan_type', 'second_loan')
                    ->first();
                
                $canApplySecond = $firstLoan && $firstLoan->percentage_paid >= 50 && !$secondLoan;
            @endphp

            <div class="bg-blue-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Loans</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $loans->count() }}</p>
                    </div>
                    <div class="text-3xl">📋</div>
                </div>
            </div>
            
            <div class="bg-green-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Active Loans</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeLoansCount }}</p>
                        <div class="text-xs text-gray-500 mt-1">
                            @if($firstLoan) 1st Loan: {{ number_format($firstLoan->percentage_paid, 1) }}% @endif
                            @if($secondLoan) | 2nd Loan @endif
                        </div>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
            </div>
            
            <div class="bg-purple-50 border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Eligible Amount</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($eligibility, 0) }}</p>
                        @if($canApplySecond)
                            <div class="text-xs text-green-600 mt-1">✓ Eligible for Second Loan</div>
                        @elseif($firstLoan && $firstLoan->percentage_paid < 50)
                            <div class="text-xs text-yellow-600 mt-1">{{ number_format(50 - $firstLoan->percentage_paid, 1) }}% to qualify for 2nd loan</div>
                        @endif
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>
        </div>

        <!-- Quick Status -->
        @if($firstLoan || $secondLoan)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($firstLoan)
            <div class="bg-white border border-blue-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-lg">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">First Loan</h3>
                            <p class="text-sm text-gray-600">{{ $firstLoan->loan_number }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold {{ $firstLoan->percentage_paid >= 50 ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ number_format($firstLoan->percentage_paid, 1) }}% Paid
                        </p>
                        @if($firstLoan->percentage_paid >= 50 && !$secondLoan)
                            <a href="{{ route('member.loans.apply') }}" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                ✓ Apply for Second Loan
                            </a>
                        @endif
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($firstLoan->percentage_paid, 100) }}%"></div>
                </div>
            </div>
            @endif

            @if($secondLoan)
            <div class="bg-white border border-green-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-600 text-lg">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Second Loan</h3>
                            <p class="text-sm text-gray-600">{{ $secondLoan->loan_number }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">
                            {{ number_format($secondLoan->percentage_paid, 1) }}% Paid
                        </p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ min($secondLoan->percentage_paid, 100) }}%"></div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Loans Table -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">All Loans</h2>
                <p class="text-sm text-gray-500 mt-1">Your loan history including first and second loans</p>
            </div>

            @if ($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">#</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Loan Details</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Amount (KES)</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">App Date</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Period</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Status</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Progress</th>
                                <th class="px-3 py-2 text-left text-gray-600 font-semibold border border-gray-200 text-xs">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($loans as $loan)
                                @php
                                    $isFirstLoan = $loan->loan_type === 'first_loan';
                                    $isSecondLoan = $loan->loan_type === 'second_loan';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Row Number -->
                                    <td class="px-3 py-2 border border-gray-200 text-gray-500 text-center">
                                        {{ $loans->firstItem() + $loop->index }}
                                    </td>

                                    <!-- Loan Details -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        <div class="font-medium text-gray-900 text-sm">{{ $loan->loan_number }}</div>
                                        <div class="flex items-center gap-1 mt-1">
                                            @if($isFirstLoan)
                                                <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">1st Loan</span>
                                            @elseif($isSecondLoan)
                                                <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">2nd Loan</span>
                                            @endif
                                            @if($loan->parentLoan)
                                                <span class="text-xs text-gray-500">← {{ $loan->parentLoan->loan_number }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        <div class="font-semibold text-gray-900">{{ number_format($loan->amount, 0) }}</div>
                                        <div class="text-xs text-gray-500">KES {{ number_format($loan->total_repayable, 0) }} total</div>
                                    </td>

                                    <!-- Application Date -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        <div class="text-gray-900 text-sm">{{ $loan->applied_date->format('d/m/Y') }}</div>
                                    </td>

                                    <!-- Period -->
                                    <td class="px-3 py-2 border border-gray-200 text-center">
                                        <div class="font-medium text-gray-900">{{ $loan->period_months }}</div>
                                        <div class="text-xs text-gray-500">months</div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        @if ($loan->status === 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full block text-center">Pending</span>
                                        @elseif ($loan->status === 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full block text-center">Approved</span>
                                        @elseif ($loan->status === 'rejected')
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full block text-center">Rejected</span>
                                        @elseif ($loan->status === 'disbursed')
                                            <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full block text-center">Active</span>
                                        @elseif ($loan->status === 'active')
                                            <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full block text-center">Active</span>
                                        @elseif ($loan->status === 'completed')
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full block text-center">Completed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full block text-center">{{ ucfirst($loan->status) }}</span>
                                        @endif
                                    </td>

                                    <!-- Progress -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1">
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="{{ $loan->percentage_paid >= 100 ? 'bg-green-600' : ($isFirstLoan ? 'bg-blue-600' : 'bg-green-600') }} h-1.5 rounded-full" 
                                                          style="width: {{ min($loan->percentage_paid, 100) }}%"></div>
                                                </div>
                                            </div>
                                            <div class="text-xs font-medium {{ $loan->percentage_paid >= 100 ? 'text-green-600' : 'text-gray-600' }}">
                                                {{ number_format($loan->percentage_paid, 0) }}%
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 text-center">
                                            {{ $loan->months_paid }}/{{ $loan->period_months }} months
                                        </div>
                                    </td>

                                    <!-- Action -->
                                    <td class="px-3 py-2 border border-gray-200">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('member.loans.show', $loan->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-medium text-xs transition text-center">
                                                View Details
                                            </a>
                                            @if($loan->status === 'active' || $loan->status === 'disbursed')
<a href="{{ route('member.loans.show', $loan->id) }}"
   class="text-green-600 hover:text-green-800 font-medium text-xs transition text-center">
    View & Pay
</a>
@endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $loans->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-5xl mb-4">📋</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Loans Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't applied for any loans yet.</p>
                    <a href="{{ route('member.loans.apply') }}"
                        class="inline-block px-6 py-3 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Apply for Your First Loan
                    </a>
                </div>
            @endif
        </div>

    </div>
@endsection