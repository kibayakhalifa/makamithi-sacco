@extends('components.dashboard-layout')

@section('title', 'Loan Approvals')

@section('content')
<div class="space-y-8">

    <!-- Header Banner -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Loan Approval System</h1>
                <p class="text-gray-500 mt-2 leading-relaxed">
                    Review, verify, and approve member loan applications
                </p>
            </div>

            <div class="text-left md:text-right mt-6 md:mt-0">
                <p class="text-gray-500">Pending Approvals</p>
                <p class="text-4xl font-semibold text-gray-900 mt-1">12</p>
                <p class="text-gray-400 text-sm mt-1">Awaiting your review</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
        @foreach ([
            ['title' => 'Pending Review', 'value' => 8, 'desc' => 'Needs verification'],
            ['title' => 'Pending Committee', 'value' => 4, 'desc' => 'Awaiting committee'],
            ['title' => 'Approved Today', 'value' => 3, 'desc' => 'KES 450,000'],
            ['title' => 'Rejected Today', 'value' => 1, 'desc' => 'Insufficient savings'],
        ] as $stat)
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-gray-500 text-xs tracking-wider uppercase font-medium">{{ $stat['title'] }}</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stat['value'] }}</p>
            <p class="text-gray-500 text-sm mt-1">{{ $stat['desc'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden">

        <div class="border-b border-gray-200">
            <nav class="flex space-x-1 p-2">
                <button id="pendingTab"
                    class="px-5 py-3 text-sm font-medium rounded-lg bg-gray-900 text-white shadow-sm transition ">
                    Pending Review (8)
                </button>

                <button id="committeeTab"
                    class="px-5 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    Committee Review (4)
                </button>

                <button id="approvedTab"
                    class="px-5 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    Approved (24)
                </button>

                <button id="rejectedTab"
                    class="px-5 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 transition">
                    Rejected (5)
                </button>
            </nav>
        </div>

        <!-- Pending Table -->
        <div id="pendingContent" class="p-8">

            <div class="overflow-x-auto">

                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Savings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-gray-800">

                        @php
                            $pendingLoans = [
                                ['id' => 1, 'name' => 'John Mule', 'emp' => 'EMP001', 'amount' => 150000, 'months' => 24, 'savings' => 100000, 'date' => 'Today', 'status' => 'Pending Review'],
                                ['id' => 2, 'name' => 'Jane Wanjiru', 'emp' => 'EMP045', 'amount' => 200000, 'months' => 18, 'savings' => 150000, 'date' => 'Today', 'status' => 'Pending Review'],
                                ['id' => 3, 'name' => 'Peter Kamau', 'emp' => 'EMP023', 'amount' => 75000, 'months' => 12, 'savings' => 60000, 'date' => 'Yesterday', 'status' => 'Pending Review'],
                                ['id' => 4, 'name' => 'Mary Njeri', 'emp' => 'EMP067', 'amount' => 300000, 'months' => 36, 'savings' => 250000, 'date' => '2 days ago', 'status' => 'Pending Review'],
                                ['id' => 5, 'name' => 'James Otieno', 'emp' => 'EMP089', 'amount' => 120000, 'months' => 24, 'savings' => 90000, 'date' => '2 days ago', 'status' => 'Pending Review'],
                            ];
                        @endphp

                        @foreach($pendingLoans as $loan)
                        <tr class="hover:bg-gray-50/80 transition">

                            <!-- Applicant -->
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-700 font-semibold mr-3 shadow-inner">
                                        {{ strtoupper(substr($loan['name'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $loan['name'] }}</p>
                                        <p class="text-gray-500 text-sm">{{ $loan['emp'] }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Loan details -->
                            <td class="px-6 py-5">
                                <p class="font-medium text-gray-900">KES {{ number_format($loan['amount'], 2) }}</p>
                                <p class="text-gray-500 text-sm">{{ $loan['months'] }} months • 5% fixed</p>
                                <p class="text-gray-500 text-sm">
                                    Monthly: KES {{ number_format(($loan['amount'] * 1.05) / $loan['months'], 2) }}
                                </p>
                            </td>

                            <!-- Savings -->
                            <td class="px-6 py-5">
                                <p class="font-medium text-gray-900">KES {{ number_format($loan['savings'], 2) }}</p>

                                <p class="text-sm {{ $loan['savings'] * 1.5 >= $loan['amount'] ? 'text-gray-700' : 'text-gray-400' }}">
                                    Qualifies: KES {{ number_format($loan['savings'] * 1.5, 2) }}
                                </p>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-5">
                                <p class="text-gray-900">{{ $loan['date'] }}</p>
                                <p class="text-gray-400 text-sm">Loan #{{ $loan['id'] }}</p>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 bg-gray-100 border border-gray-300 rounded-full text-xs font-medium text-gray-700 whitespace-nowrap">
                                    {{ $loan['status'] }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-5">
                                <div class="flex space-x-2">

                                    <!-- View -->
                                    <button onclick="viewLoan({{ $loan['id'] }})"
                                        class="px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-md text-sm transition">
                                        View
                                    </button>

                                    <!-- Verify -->
                                    <button onclick="verifyLoan({{ $loan['id'] }})"
                                        class="px-3 py-1.5 bg-gray-900 hover:bg-gray-800 text-white border border-gray-900 rounded-md text-sm transition">
                                        Verify
                                    </button>

                                    <!-- Reject -->
                                    <button onclick="rejectLoan({{ $loan['id'] }})"
                                        class="px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-md text-sm transition">
                                        Reject
                                    </button>

                                </div>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-between items-center text-gray-600">
                <p>Showing 5 of 8 pending applications</p>

                <button class="px-5 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 rounded-lg font-medium shadow-sm transition">
                    Load More
                </button>
            </div>
        </div>

        <!-- Other Tabs -->
        <div id="committeeContent" class="p-8 hidden text-gray-500">
            Applications awaiting committee approval will appear here.
        </div>

        <div id="approvedContent" class="p-8 hidden text-gray-500">
            Approved loan applications will appear here.
        </div>

        <div id="rejectedContent" class="p-8 hidden text-gray-500">
            Rejected loan applications will appear here.
        </div>
    </div>
</div>

@include('components.loan-modal')
@endsection
