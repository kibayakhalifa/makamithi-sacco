@extends('components.dashboard-layout')

@section('title', 'Loan History')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Loan History</h1>
                    <p class="text-blue-800 mt-2">View all loan applications and their current status</p>
                </div>
                <div class="text-right">
                    <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                        <p class="text-blue-600 text-sm font-medium">Total Loans</p>
                        <p class="text-4xl font-bold text-gray-900">{{ $loanStats['total_loans'] }}</p>
                        <p class="text-gray-500 text-xs mt-1">Amount: KES {{ number_format($loanStats['total_amount'], 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending</h3>
                        <p class="text-2xl font-bold text-orange-600 mt-2">{{ $loanStats['pending_loans'] }}</p>
                    </div>
                    <span class="text-2xl">⏳</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Approved</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{ $loanStats['approved_loans'] }}</p>
                    </div>
                    <span class="text-2xl">✅</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{ $loanStats['active_loans'] }}</p>
                    </div>
                    <span class="text-2xl">📈</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Rejected</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{ $loanStats['rejected_loans'] }}</p>
                    </div>
                    <span class="text-2xl">❌</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Completed</h3>
                        <p class="text-2xl font-bold text-purple-600 mt-2">{{ $loanStats['completed_loans'] }}</p>
                    </div>
                    <span class="text-2xl">🎉</span>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <h2 class="text-lg font-bold text-gray-900">All Loans</h2>
                    <div class="flex gap-3 w-full md:w-auto">
                        <input type="text" placeholder="Search loans..."
                            class="flex-1 md:flex-none px-4 py-2 border border-gray-300 rounded-lg text-sm"
                            id="searchInput">
                        <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="active">Active</option>
                            <option value="rejected">Rejected</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Loan #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Member
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Amount
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Purpose
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Applied
                                Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-b">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-3 border-b text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 border-b">
                                    <p class="font-semibold text-gray-900">#{{ $loan->loan_number }}</p>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $loan->user->employee_number }}</p>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <p class="font-bold text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                    <p class="text-gray-500 text-xs">5% interest</p>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <p class="text-gray-600 text-sm">{{ $loan->purpose }}</p>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <p class="text-gray-900">{{ $loan->applied_date?->format('d M Y') ?? 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    @if($loan->status === 'pending')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs rounded-full font-medium">⏳
                                            Pending</span>
                                    @elseif($loan->status === 'approved')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">✅
                                            Approved</span>
                                    @elseif(in_array($loan->status, ['active', 'disbursed']))
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">📈
                                            Active</span>
                                    @elseif($loan->status === 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full font-medium">❌
                                            Rejected</span>
                                    @elseif($loan->status === 'completed')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full font-medium">🎉
                                            Completed</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <a href="{{ route('secretary.loan-approval-detail', $loan->id) }}"
                                        class="text-blue-600 hover:text-blue-700 font-semibold text-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t">
                {{ $loans->links() }}
            </div>
        </div>

    </div>

    <script>
        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            filterTable();
        });

        document.getElementById('statusFilter').addEventListener('change', function () {
            filterTable();
        });

        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const statusValue = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const loanNumber = row.cells[1].textContent.toLowerCase();
                const memberName = row.cells[2].textContent.toLowerCase();
                const status = row.cells[6].textContent.toLowerCase();

                const matchesSearch = loanNumber.includes(searchValue) || memberName.includes(searchValue);
                const matchesStatus = statusValue === '' || status.includes(statusValue);

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }
    </script>
@endsection