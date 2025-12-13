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
                $stats = [
                    ['title' => 'Total Loans', 'value' => $loans->count(), 'icon' => '📋', 'color' => 'bg-blue-50'],
                    ['title' => 'Active Loans', 'value' => $activeLoans->count(), 'icon' => '✅', 'color' => 'bg-green-50'],
                    ['title' => 'Eligible Amount', 'value' => 'KES ' . number_format($eligibility, 2), 'icon' => '💰', 'color' => 'bg-purple-50'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="{{ $stat['color'] }} border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">{{ $stat['title'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stat['value'] }}</p>
                        </div>
                        <div class="text-3xl">{{ $stat['icon'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Loans Table -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">All Loans</h2>
            </div>

            @if ($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse" style="border:1px solid #e5e7eb;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">#</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Loan Details</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Amount</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Period</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Applied Date</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Status</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($loans as $loan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loans->firstItem() + $loop->index }}</td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">{{ $loan->loan_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->purpose ?? 'General Purpose' }}</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">Interest: {{ $loan->interest_rate }}%</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">{{ $loan->period_months }} months</p>
                                        <p class="text-sm text-gray-500">KES {{ number_format($loan->monthly_payment, 2) }}/month</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="text-gray-900">{{ $loan->applied_date->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->applied_date->diffForHumans() }}</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        @if ($loan->status === 'pending')
                                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">⏳ Pending</span>
                                        @elseif ($loan->status === 'approved')
                                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✅ Approved</span>
                                        @elseif ($loan->status === 'rejected')
                                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">❌ Rejected</span>
                                        @elseif ($loan->status === 'disbursed')
                                            <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">💸 Disbursed</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full">{{ ucfirst($loan->status) }}</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="{{ route('member.loans.show', $loan->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition">View Details →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
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