@extends('components.dashboard-layout')

@section('title', 'My Loans')

@section('content')
    <div class="space-y-4">

        <!-- Compact Header -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">My Loans</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Manage and track your loan applications</p>
                </div>
                <a href="{{ route('member.loans.apply') }}"
                    class="inline-flex items-center justify-center px-3 py-1.5 rounded bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-xs mt-2 sm:mt-0">
                    + Apply New Loan
                </a>
            </div>
        </div>

        <!-- Compact Loan Stats -->
        @php
            $user = auth()->user();
            $firstLoan = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->where('loan_type', 'first_loan')
                ->first();
            
            $secondLoan = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->where('loan_type', 'second_loan')
                ->first();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <!-- Total Eligibility -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs text-gray-600 font-medium truncate">Total Eligibility</p>
                        <p class="text-base font-bold text-blue-900 mt-1 truncate">KES {{ number_format($total_eligibility, 0) }}</p>
                    </div>
                    <div class="text-lg ml-2">💰</div>
                </div>
                <p class="text-xs text-gray-500 mt-1 truncate">Savings × 1.5</p>
            </div>
            
            <!-- Current Balance -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs text-gray-600 font-medium truncate">Current Balance</p>
                        <p class="text-base font-bold text-amber-900 mt-1 truncate">KES {{ number_format($current_loan_balance, 0) }}</p>
                    </div>
                    <div class="text-lg ml-2">📊</div>
                </div>
                <p class="text-xs text-gray-500 mt-1 truncate">Active loans balance</p>
            </div>
            
            <!-- Available -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs text-gray-600 font-medium truncate">Available</p>
                        <p class="text-base font-bold text-green-900 mt-1 truncate">KES {{ number_format($available_eligibility, 0) }}</p>
                    </div>
                    <div class="text-lg ml-2">✅</div>
                </div>
                <p class="text-xs text-gray-500 mt-1 truncate">Can borrow</p>
            </div>
        </div>

        <!-- Mini Loan Progress -->
        @if($firstLoan || $secondLoan)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @if($firstLoan)
            <div class="bg-white border border-blue-200 rounded-lg p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-xs">1</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xs font-semibold text-gray-900 truncate">First Loan</h3>
                            <p class="text-xs text-gray-500 truncate">{{ $firstLoan->loan_number }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold {{ $firstLoan->percentage_paid >= 50 ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ number_format($firstLoan->percentage_paid, 1) }}%
                        </p>
                        @if($firstLoan->percentage_paid >= 50 && !$secondLoan)
                            <a href="{{ route('member.loans.apply') }}" class="text-xs text-blue-600 hover:underline mt-0.5 block">
                                ✓ Apply 2nd
                            </a>
                        @endif
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min($firstLoan->percentage_paid, 100) }}%"></div>
                </div>
            </div>
            @endif

            @if($secondLoan)
            <div class="bg-white border border-green-200 rounded-lg p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-600 text-xs">2</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xs font-semibold text-gray-900 truncate">Second Loan</h3>
                            <p class="text-xs text-gray-500 truncate">{{ $secondLoan->loan_number }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-green-600">
                            {{ number_format($secondLoan->percentage_paid, 1) }}%
                        </p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ min($secondLoan->percentage_paid, 100) }}%"></div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Compact Table -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">All Loans</h2>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $loans->total() }} total loans</p>
                    </div>
                    @if($firstLoan && $firstLoan->percentage_paid >= 50 && !$secondLoan)
                    <a href="{{ route('member.loans.apply') }}"
                        class="inline-flex items-center justify-center px-3 py-1.5 rounded bg-green-600 text-white font-medium hover:bg-green-700 transition text-xs">
                        ✓ Apply 2nd Loan
                    </a>
                    @endif
                </div>
            </div>

            @if ($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">#</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Loan ID</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Amount</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Applied</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Period</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Rate</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Payable</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Monthly</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase border-r border-gray-200">Status</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach ($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <!-- Row Number -->
                                    <td class="px-3 py-2 text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- Loan ID -->
                                    <td class="px-3 py-2">
                                        <div class="font-medium text-gray-900 truncate max-w-[80px]" title="{{ $loan->loan_number }}">
                                            {{ $loan->loan_number }}
                                        </div>
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-3 py-2 font-medium">
                                        {{ number_format($loan->amount, 0) }}
                                    </td>

                                    <!-- Applied Date -->
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $loan->applied_date->format('d/m/y') }}
                                    </td>

                                    <!-- Period -->
                                    <td class="px-3 py-2">
                                        {{ $loan->period_months }}m
                                    </td>

                                    <!-- Interest Rate -->
                                    <td class="px-3 py-2">
                                        {{ number_format($loan->interest_rate, 1) }}%
                                    </td>

                                    <!-- Payable -->
                                    <td class="px-3 py-2 font-medium">
                                        {{ number_format($loan->total_repayable, 0) }}
                                    </td>

                                    <!-- Monthly -->
                                    <td class="px-3 py-2 font-medium">
                                        {{ number_format($loan->monthly_payment, 0) }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-3 py-2">
                                        @if ($loan->status === 'pending')
                                            <span class="px-1.5 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded">Pending</span>
                                        @elseif ($loan->status === 'approved')
                                            <span class="px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">Approved</span>
                                        @elseif ($loan->status === 'rejected')
                                            <span class="px-1.5 py-0.5 text-xs bg-red-100 text-red-800 rounded">Rejected</span>
                                        @elseif ($loan->status === 'disbursed' || $loan->status === 'active')
                                            <span class="px-1.5 py-0.5 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                        @elseif ($loan->status === 'completed')
                                            <span class="px-1.5 py-0.5 text-xs bg-gray-100 text-gray-800 rounded">Completed</span>
                                        @else
                                            <span class="px-1.5 py-0.5 text-xs bg-gray-100 text-gray-800 rounded">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action -->
                                    <td class="px-3 py-2">
                                        <a href="{{ route('member.loans.show', $loan->id) }}" 
                                           class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100 transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Compact Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs">
                        <div class="text-gray-700">
                            Page {{ $loans->currentPage() }} of {{ $loans->lastPage() }} • {{ $loans->total() }} loans
                        </div>
                        <div>
                            {{ $loans->links('pagination::simple-tailwind') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-3xl mb-2">📋</div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">No Loans Yet</h3>
                    <p class="text-xs text-gray-500 mb-4">You haven't applied for any loans yet.</p>
                    <a href="{{ route('member.loans.apply') }}"
                        class="inline-block px-4 py-2 rounded bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-xs">
                        Apply for Your First Loan
                    </a>
                </div>
            @endif
        </div>

        <!-- Mini Eligibility Summary -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-xs">
            <h4 class="font-semibold text-gray-900 mb-2">Eligibility Summary</h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <p class="text-gray-600">Savings:</p>
                    <p class="font-medium">KES {{ number_format($total_eligibility / 1.5, 0) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">× 1.5:</p>
                    <p class="font-medium text-blue-600">KES {{ number_format($total_eligibility, 0) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">- Current loans:</p>
                    <p class="font-medium text-amber-600">KES {{ number_format($current_loan_balance, 0) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Available:</p>
                    <p class="font-medium text-green-600">KES {{ number_format($available_eligibility, 0) }}</p>
                </div>
            </div>
        </div>

    </div>
@endsection