@extends('components.dashboard-layout')

@section('title', 'Disbursed Loans')

@section('content')
<div class="space-y-8">

    <!-- Header Banner -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Disbursed Loans</h1>
                <p class="text-gray-500 mt-2 leading-relaxed">
                    All active and disbursed loans with repayment tracking
                </p>
            </div>
            
            <div class="flex gap-4 mt-6 md:mt-0">
                <div class="text-left md:text-right">
                    <p class="text-gray-500">Total Disbursed</p>
                    <p class="text-4xl font-semibold text-gray-900 mt-1">{{ $stats['total_disbursed'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">Active loans</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Total Disbursed</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['total_disbursed'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Active loans</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Amount Disbursed</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">KES {{ number_format($stats['disbursed_amount'], 2) }}</p>
            <p class="text-gray-500 text-sm mt-1">Total disbursed</p>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Completed</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['completed_loans'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Fully paid</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Defaulted</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['defaulted_loans'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Overdue payments</p>
        </div>
    </div>

    <!-- Disbursed Loans Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Disbursed Loans ({{ $disbursedLoans->total() }})</h2>
        </div>

        @if($disbursedLoans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Applicant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Amount (KES)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Disbursed Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Disbursed By</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Next Payment</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($disbursedLoans as $loan)
                            @php
                                // Use next_payment_date from the database directly
                                $nextPaymentDate = $loan->next_payment_date;
                                $statusClass = $loan->status === 'active' ? 'bg-green-100 text-green-800' : 
                                              ($loan->status === 'defaulted' ? 'bg-red-100 text-red-800' : 
                                              ($loan->status === 'disbursed' ? 'bg-blue-100 text-blue-800' : 
                                              'bg-gray-100 text-gray-800'));
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="font-bold text-gray-900"> {{ number_format($loan->amount, 2) }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="text-gray-700">{{ $loan->disbursed_date ? \Carbon\Carbon::parse($loan->disbursed_date)->format('d M Y') : 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="text-gray-700">{{ $loan->disburser->name ?? 'System' }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <span class="px-3 py-1 {{ $statusClass }} rounded-full text-xs font-medium">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    @if($nextPaymentDate)
                                        <p class="text-gray-700">{{ \Carbon\Carbon::parse($nextPaymentDate)->format('d M Y') }}</p>
                                        <p class="text-gray-500 text-xs">KES {{ number_format($loan->monthly_payment, 2) }}</p>
                                    @else
                                        <p class="text-gray-400">No payments due</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <a href="{{ route('chairman.loans.approve-view', $loan->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-700 font-medium text-sm mr-4">
                                        View
                                    </a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $disbursedLoans->links() }}
            </div>
        @else
            <div class="p-8 text-center bg-blue-50 rounded-lg">
                <p class="text-blue-700 font-semibold text-lg">No disbursed loans found</p>
                <p class="text-gray-600 mt-2">All loans are either pending approval or approved but not yet disbursed.</p>
            </div>
        @endif
    </div>

</div>
@endsection