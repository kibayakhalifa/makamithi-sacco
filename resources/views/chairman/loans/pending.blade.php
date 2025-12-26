@extends('components.dashboard-layout')

@section('title', 'Pending Loans')

@section('content')
<div class="space-y-8">

    <!-- Header Banner -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Pending Loans</h1>
                <p class="text-gray-500 mt-2 leading-relaxed">
                    All loan applications awaiting review and approval
                </p>
            </div>
            
            <div class="flex gap-4 mt-6 md:mt-0">
                <div class="text-left md:text-right">
                    <p class="text-gray-500">Pending Review</p>
                    <p class="text-4xl font-semibold text-gray-900 mt-1">{{ $stats['pending_loans'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">Awaiting approval</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Pending Review</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['pending_loans'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Needs approval</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Approved Today</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['approved_today'] }}</p>
            <p class="text-gray-500 text-sm mt-1">Approved in last 24 hours</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Total Approved</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['total_approved'] }}</p>
            <p class="text-gray-500 text-sm mt-1">All time approvals</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">Total Disbursed</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">KES {{ number_format($stats['total_disbursed'], 2) }}</p>
            <p class="text-gray-500 text-sm mt-1">Amount disbursed</p>
        </div>
    </div>

    <!-- Pending Applications -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Pending Applications ({{ $pendingLoans->total() }})</h2>
            <a href="{{ route('chairman.loan-approvals') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                Go to Approval Dashboard
            </a>
        </div>

        @if($pendingLoans->count() > 0)
            <div class="space-y-4">
                @foreach($pendingLoans as $loan)
                    <div class="border border-gray-200 rounded-lg p-5 hover:bg-gray-50 transition">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <!-- Loan Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold">{{ strtoupper(substr($loan->user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $loan->user->name }}</p>
                                        <p class="text-gray-600 text-sm">{{ $loan->user->employee_number }} • {{ $loan->user->department ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4 text-sm">
                                    <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                        <p class="text-gray-600">Amount</p>
                                        <p class="font-bold text-green-600">KES {{ number_format($loan->amount, 2) }}</p>
                                    </div>
                                    <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                        <p class="text-gray-600">Period</p>
                                        <p class="font-bold text-gray-900">{{ $loan->period_months }} months</p>
                                    </div>
                                    <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                        <p class="text-gray-600">Savings</p>
                                        <p class="font-bold text-blue-600">KES {{ number_format($loan->user->savings->available_savings ?? 0, 2) }}</p>
                                    </div>
                                    <div class="p-3 border border-gray-200 rounded bg-gray-50">
                                        <p class="text-gray-600">Applied</p>
                                        <p class="font-bold text-gray-900">{{ $loan->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="p-3 border border-gray-200 rounded bg-gray-50 flex items-center justify-center">
                                        <a href="{{ route('chairman.loans.approve-view', $loan->id) }}" 
                                           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition text-center">
                                            Review & Approve
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pendingLoans->links() }}
            </div>
        @else
            <div class="p-8 text-center bg-green-50 rounded-lg">
                <p class="text-green-700 font-semibold text-lg">✓ No pending loan applications</p>
                <p class="text-gray-600 mt-2">All applications have been processed.</p>
            </div>
        @endif
    </div>

</div>
@endsection