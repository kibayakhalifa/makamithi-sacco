@extends('components.dashboard-layout')

@section('title', 'Loan Approvals')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Pending Loan Approvals</h1>
                    <p class="text-gray-500 mt-1">Review and approve member loan applications</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Pending</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $loans->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            @if ($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse" style="border:1px solid #e5e7eb;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">#</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Member</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Loan Number
                                </th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Amount</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Purpose</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Applied Date
                                </th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold border border-gray-200">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($loans as $loan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 border border-gray-200 text-gray-700">
                                        {{ $loans->firstItem() + $loop->index }}</td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">{{ $loan->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->user->employee_number }}</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200 font-mono text-gray-900">{{ $loan->loan_number }}
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="font-semibold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->period_months }} months</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200 text-gray-700">{{ $loan->purpose ?? 'General' }}
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <p class="text-gray-900">{{ $loan->applied_date->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->applied_date->diffForHumans() }}</p>
                                    </td>

                                    <td class="px-4 py-3 border border-gray-200">
                                        <a href="{{ route('secretary.loan-approval-detail', $loan->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition">Review →</a>
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
                    <div class="text-5xl mb-4">✅</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Pending Loans</h3>
                    <p class="text-gray-500">All loan applications have been reviewed.</p>
                </div>
            @endif
        </div>

    </div>
@endsection