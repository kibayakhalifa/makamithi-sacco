@extends('components.dashboard-layout')

@section('title', 'Approved Loans')

@section('content')
<div class="space-y-8">

    <!-- Header Banner -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Approved Loans</h1>
                <p class="text-gray-500 mt-2 leading-relaxed">
                    All approved loan applications awaiting disbursement
                </p>
            </div>
            
            <div class="flex gap-4 mt-6 md:mt-0">
                <div class="text-left md:text-right">
                    <p class="text-gray-500">Total Approved</p>
                    <p class="text-4xl font-semibold text-gray-900 mt-1">{{ $stats['total_approved'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">All time approvals</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Total Approved</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['total_approved'] }}</p>
            <p class="text-gray-500 text-sm mt-1">All approved loans</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Approved This Month</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['approved_this_month'] }}</p>
            <p class="text-gray-500 text-sm mt-1">This month approvals</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Approved Amount</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">KES {{ number_format($stats['approved_amount'], 2) }}</p>
            <p class="text-gray-500 text-sm mt-1">Total approved amount</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Pending Approvals</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['pending_approvals'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Awaiting review</p>
        </div>
    </div>

    <!-- Approved Loans Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Approved Loans ({{ $approvedLoans->total() }})</h2>
        </div>

        @if($approvedLoans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse" style="border:1px solid #e5e7eb;">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Applicant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Period</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Approved By</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Approved Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedLoans as $loan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="text-gray-700">{{ $loan->period_months }} months</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="text-gray-700">{{ $loan->approver->name ?? 'System' }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <p class="text-gray-700">{{ $loan->approved_date ? $loan->approved_date->format('d M Y') : 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 border border-gray-200">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        Approved
                                    </span>
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
                {{ $approvedLoans->links() }}
            </div>
        @else
            <div class="p-8 text-center bg-yellow-50 rounded-lg">
                <p class="text-yellow-700 font-semibold text-lg">No approved loans found</p>
                <p class="text-gray-600 mt-2">All approved loans have been disbursed or moved to active status.</p>
            </div>
        @endif
    </div>

</div>
@endsection