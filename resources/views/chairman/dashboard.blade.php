@extends('components.dashboard-layout')

@section('title', 'Chairman Dashboard')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Chairman Dashboard</h1>
                    <p class="text-gray-500 mt-1">
                        Welcome back, {{ auth()->user()->name }} — review ongoing member loan activities.
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending Approvals</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['pending_approvals'] }}</p>
                    </div>
                    <div class="text-3xl">⏳</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Approved This Month</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['approved_this_month'] }}</p>
                    </div>
                    <div class="text-3xl">✔️</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Members</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['total_members'] }}</p>
                    </div>
                    <div class="text-3xl">👥</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['active_loans'] }}</p>
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>
        </div>

        <!-- Pending Member Registrations -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Pending Member Approvals ({{ $pendingMembers->count() }})
                </h2>
                <a href="{{ route('chairman.members') }}"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            @if($pendingMembers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Member Name</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Employee #</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Department</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Submitted By</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Date</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingMembers as $index => $member)
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 border-r border-gray-300">{{ $member->employee_number }}</td>
                                    <td class="px-6 py-4 text-gray-600 border-r border-gray-300">{{ $member->department ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-gray-600 border-r border-gray-300">
                                        {{ $member->memberApproval?->submittedBy?->name ?? 'System' }}</td>
                                    <td class="px-6 py-4 text-gray-500 border-r border-gray-300">{{ $member->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="relative inline-block group">
                                            <button class="px-4 py-2 bg-gray-600 text-white rounded-lg text-xs font-medium hover:bg-gray-700 transition flex items-center gap-1">
                                                Actions ▼
                                            </button>
                                            <div class="hidden group-hover:block absolute right-0 mt-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                                <form action="{{ route('chairman.members.approve', $member->id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-green-600 hover:bg-green-50 border-b border-gray-200 text-sm">✓ Approve</button>
                                                </form>
                                                <form action="{{ route('chairman.members.approve', $member->id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 border-b border-gray-200 text-sm">✗ Reject</button>
                                                </form>
                                                <button type="button" onclick="viewMemberModal({{ $member->id }}, '{{ $member->name }}')" class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50 text-sm">👁 View Details</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No pending member approvals</p>
                </div>
            @endif
        </div>

        <!-- Pending Loans -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Pending Loan Approvals ({{ $pendingLoans->count() }})</h2>
                <a href="{{ route('chairman.loan-approvals') }}"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    View All
                </a>
            </div>

            @if($pendingLoans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Member</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Loan Amount</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Eligibility</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Period</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Applied</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingLoans as $index => $loan)
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="font-medium text-gray-900">{{ $loan->user->name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $loan->user->employee_number }}</p>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="font-medium text-gray-900">KES {{ number_format($loan->amount, 2) }}</p>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="text-gray-900">KES {{ number_format($loan->user->savings?->available_savings * 1.5 ?? 0, 2) }}</p>
                                        <p class="text-gray-500 text-xs">Savings: KES {{ number_format($loan->user->savings?->available_savings ?? 0, 2) }}</p>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="font-medium text-gray-900">{{ $loan->period_months }} months</p>
                                        <p class="text-gray-500 text-xs">Monthly: KES {{ number_format($loan->monthly_payment, 2) }}</p>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <p class="font-medium text-gray-900">{{ $loan->applied_date->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="relative inline-block group">
                                            <button class="px-4 py-2 bg-gray-600 text-white rounded-lg text-xs font-medium hover:bg-gray-700 transition flex items-center gap-1">
                                                Actions ▼
                                            </button>
                                            <div class="hidden group-hover:block absolute right-0 mt-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                                <a href="{{ route('chairman.loans.approve-view', $loan->id) }}" class="w-full block px-4 py-2 text-blue-600 hover:bg-blue-50 border-b border-gray-200 text-sm">👁 View Details</a>
                                                <a href="{{ route('chairman.loans.approve-view', $loan->id) }}" class="w-full block px-4 py-2 text-green-600 hover:bg-green-50 border-b border-gray-200 text-sm">✓ Approve</a>
                                                <a href="{{ route('chairman.loans.approve-view', $loan->id) }}" class="w-full block px-4 py-2 text-red-600 hover:bg-red-50 text-sm">✗ Reject</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No pending loan approvals</p>
                </div>
            @endif
        </div>

        <!-- Activity + Reports -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Recent Activity -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    @php
                        $activities = [
                            (object)[
                                'type' => 'loan_approved',
                                'icon' => '✔️',
                                'title' => 'Loan Approved',
                                'member' => 'Jane Doe',
                                'amount' => 200000,
                                'time' => now()->subHours(2)
                            ],
                            (object)[
                                'type' => 'member_approved',
                                'icon' => '👥',
                                'title' => 'Member Registration Approved',
                                'member' => 'John Smith',
                                'amount' => null,
                                'time' => now()->subHours(4)
                            ],
                            (object)[
                                'type' => 'loan_applied',
                                'icon' => '📝',
                                'title' => 'New Loan Application',
                                'member' => 'Sarah Johnson',
                                'amount' => 150000,
                                'time' => now()->subHours(6)
                            ],
                            (object)[
                                'type' => 'member_applied',
                                'icon' => '📋',
                                'title' => 'New Member Registration',
                                'member' => 'Mike Wilson',
                                'amount' => null,
                                'time' => now()->subHours(8)
                            ],
                        ];
                    @endphp
                    @foreach($activities as $activity)
                        <div class="flex items-start pb-3 border-b border-gray-200 last:border-b-0">
                            <div class="p-2 rounded-full bg-gray-100 mr-3 text-lg min-w-fit">
                                {{ $activity->icon }}
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-gray-600 text-sm">{{ $activity->member }}
                                    @if($activity->amount)
                                        — KES {{ number_format($activity->amount, 2) }}
                                    @endif
                                </p>
                                <p class="text-gray-400 text-xs">{{ $activity->time->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Reports -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Generate Reports</h3>

                <div class="space-y-3">
                    <button onclick="openReportModal('financial')" class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                        📊 Generate Financial Report
                    </button>
                    <button onclick="openReportModal('loan_performance')" class="w-full flex items-center justify-center gap-2 bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition">
                        💰 Loan Performance Report
                    </button>
                    <button onclick="openReportModal('members')" class="w-full flex items-center justify-center gap-2 bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition">
                        👥 Member Statistics
                    </button>
                    <button onclick="openReportModal('savings')" class="w-full flex items-center justify-center gap-2 bg-orange-600 text-white py-3 rounded-lg font-medium hover:bg-orange-700 transition">
                        📈 Savings Growth Report
                    </button>
                    <a href="{{ route('reports.index') }}" class="w-full flex items-center justify-center gap-2 bg-gray-600 text-white py-3 rounded-lg font-medium hover:bg-gray-700 transition">
                        📋 View All Reports
                    </a>
                </div>
            </div>
        </div>

        <!-- Report Generation Modal -->
        <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
                <div class="p-6 border-b sticky top-0 bg-white">
                    <h2 class="text-xl font-bold text-gray-900" id="reportTitle">Generate Report</h2>
                </div>

                <form action="{{ route('reports.generate') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="report_type" id="reportType">

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Start Date</label>
                        <input type="date" name="start_date" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ now()->subMonths(3)->toDateString() }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">End Date</label>
                        <input type="date" name="end_date" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ now()->toDateString() }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Format</label>
                        <select name="format" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openReportModal(reportType) {
                const titles = {
                    'financial': 'Generate Financial Report',
                    'loan_performance': 'Loan Performance Report',
                    'members': 'Member Statistics Report',
                    'savings': 'Savings Growth Report'
                };
                document.getElementById('reportType').value = reportType;
                document.getElementById('reportTitle').textContent = titles[reportType];
                document.getElementById('reportModal').classList.remove('hidden');
            }

            document.getElementById('reportModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            function viewMemberModal(memberId, memberName) {
                // Redirect to member view page
                window.location.href = '/chairman/members/' + memberId;
            }
        </script>
    </div>
@endsection