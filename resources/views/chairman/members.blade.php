@extends('components.dashboard-layout')

@section('title', 'Member Management - Chairman')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Management</h1>
                    <p class="text-gray-500 mt-1">
                        Hello {{ auth()->user()->name }} — review and approve member applications, manage SACCO membership.
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Members -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Members</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['total_members'] }}</p>
                        @if($stats['pending_members'] > 0)
                            <p class="text-xs text-yellow-600 mt-1">{{ $stats['pending_members'] }} pending approval</p>
                        @else
                            <p class="text-xs text-green-600 mt-1">All members approved</p>
                        @endif
                    </div>
                    <div class="text-3xl text-gray-300">👥</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Active: {{ $stats['active_members'] ?? 0 }}</span>
                        <span>Pending: {{ $stats['pending_members'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Pending Approval</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['pending_members'] }}</p>
                        <p class="text-xs text-yellow-600 mt-1">Require your review</p>
                    </div>
                    <div class="text-3xl text-yellow-300">⏳</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>New: {{ $pendingMembersList->where('days_pending', 0)->count() }}</span>
                        @php
                            $oldestDays = $pendingMembersList->max('days_pending') ?? 0;
                        @endphp
                        <span>Oldest: {{ $oldestDays }} days</span>
                    </div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">{{ $stats['active_loans'] }}</p>
                        <p class="text-xs text-blue-600 mt-1">KES {{ number_format($stats['total_loan_amount']) }} total</p>
                    </div>
                    <div class="text-3xl text-blue-300">📝</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Defaulting: {{ $stats['defaulted_loans'] }}</span>
                        <span>Amount: KES {{ number_format($stats['total_loan_amount']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Savings -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">KES {{ number_format($stats['total_savings']) }}</p>
                        @if($stats['monthly_savings_increase'] > 0)
                            <p class="text-xs text-green-600 mt-1">+KES {{ number_format($stats['monthly_savings_increase']) }} this month</p>
                        @else
                            <p class="text-xs text-gray-500 mt-1">No increase this month</p>
                        @endif
                    </div>
                    <div class="text-3xl text-green-300">💰</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Members: {{ $stats['active_members'] ?? 0 }}</span>
                        <span>Avg: KES {{ $stats['total_members'] > 0 ? number_format($stats['total_savings'] / $stats['total_members']) : 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Pending Member Approvals</h2>
                    <p class="text-gray-500 text-sm mt-1">New members awaiting your approval</p>
                </div>
                @if($pendingMembersList->count() > 0)
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        {{ $pendingMembersList->count() }} pending
                    </span>
                @else
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        All approved
                    </span>
                @endif
            </div>

            @if($pendingMembersList->count() > 0)
                <div class="overflow-x-auto border border-gray-300 rounded-lg">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">#</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Emp No</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Full Name</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Email</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Department</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Position</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Submitted</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Days Ago</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pendingMembersList as $index => $member)
                                @php
                                    $submittedDate = \Carbon\Carbon::parse($member['submitted_date']);
                                    $submittedAgo = $submittedDate->diffForHumans();
                                @endphp
                                <tr class="border-t border-gray-300 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-900 font-medium border border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-900 border border-gray-300">{{ $member['employee_number'] }}</td>
                                    <td class="px-4 py-3 border border-gray-300 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $member['name'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-700 truncate max-w-[150px]">{{ $member['email'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">{{ $member['department'] }}</td>
                                    <td class="px-4 py-3 border border-gray-300">{{ $member['position'] }}</td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="text-gray-700">{{ $submittedDate->format('M d, Y') }}</div>
                                        <div class="text-gray-500 text-xs">By {{ $member['submitted_by'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <span class="px-2 py-1 bg-{{ $member['days_pending'] > 7 ? 'red' : 'yellow' }}-100 text-{{ $member['days_pending'] > 7 ? 'red' : 'yellow' }}-800 rounded text-xs whitespace-nowrap">
                                            {{ $member['days_pending'] }} day{{ $member['days_pending'] !== 1 ? 's' : '' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-300">
                                        <div class="flex gap-1">
                                            <button onclick="viewMemberDetails({{ $member['id'] }})"
                                                class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200 whitespace-nowrap">
                                                View
                                            </button>
                                            <button onclick="approveMember({{ $member['id'] }})"
                                                class="px-2 py-1 bg-green-50 text-green-700 hover:bg-green-100 rounded text-xs font-medium border border-green-200 whitespace-nowrap">
                                                Approve
                                            </button>
                                            <button onclick="rejectMember({{ $member['id'] }})"
                                                class="px-2 py-1 bg-red-50 text-red-700 hover:bg-red-100 rounded text-xs font-medium border border-red-200 whitespace-nowrap">
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 border border-gray-300 rounded-lg">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900">No pending approvals</h3>
                    <p class="text-gray-500 mt-1">All members have been approved</p>
                </div>
            @endif
        </div>

        <!-- All Members Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">All SACCO Members</h2>
                    <p class="text-gray-500 text-sm mt-1">Complete list of Makamithi SACCO members</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                    <input type="text" placeholder="Search members..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm w-full sm:w-48" id="searchMembers">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm w-full sm:w-40" id="filterDepartment">
                        <option value="">All Departments</option>
                        @php
                            $departments = $allMembers->pluck('department')->unique()->filter()->sort();
                        @endphp
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm w-full sm:w-32" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="w-full text-sm border-collapse" id="membersTable">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Emp No</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Full Name</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Email</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Department</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Position</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Savings (KES)</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Loan Eligibility</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-semibold border border-gray-300">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="membersTableBody">
                        @foreach($allMembers as $index => $member)
                            @php
                                $joinedDate = \Carbon\Carbon::parse($member['date_joined']);
                                $joinedAgo = $joinedDate->diffForHumans();
                            @endphp
                            <tr class="border-t border-gray-300 hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-900 font-medium border border-gray-300 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-mono text-gray-900 border border-gray-300 whitespace-nowrap">{{ $member['employee_number'] }}</td>
                                <td class="px-4 py-3 border border-gray-300 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $member['name'] }}</div>
                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="text-gray-700 truncate max-w-[150px]">{{ $member['email'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 border border-gray-300">{{ $member['department'] }}</td>
                                <td class="px-4 py-3 text-gray-700 border border-gray-300">{{ $member['position'] }}</td>
                                <td class="px-4 py-3 border border-gray-300 text-right whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ number_format($member['savings']) }}</div>
                                </td>
                                <td class="px-4 py-3 border border-gray-300 text-right whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ number_format($member['loan_eligibility']) }}</div>
                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    @if($member['status'] === 'active')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium whitespace-nowrap">Active</span>
                                    @elseif($member['status'] === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium whitespace-nowrap">Pending</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium whitespace-nowrap">Inactive</span>
                                    @endif
                                    @if($member['loan_status'] === 'default')
                                        <div class="mt-1"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded text-xs whitespace-nowrap">Default</span></div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border border-gray-300">
                                    <div class="flex gap-1">
                                        <button onclick="viewMemberDetails({{ $member['id'] }})"
                                            class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200 whitespace-nowrap">
                                            View
                                        </button>
                                        @if($member['status'] === 'pending')
                                            <button onclick="approveMember({{ $member['id'] }})"
                                                class="px-2 py-1 bg-green-50 text-green-700 hover:bg-green-100 rounded text-xs font-medium border border-green-200 whitespace-nowrap">
                                                Approve
                                            </button>
                                            <button onclick="rejectMember({{ $member['id'] }})"
                                                class="px-2 py-1 bg-red-50 text-red-700 hover:bg-red-100 rounded text-xs font-medium border border-red-200 whitespace-nowrap">
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Member Count -->
            <div class="flex justify-between items-center mt-4">
                <p class="text-sm text-gray-500" id="paginationInfo">
                    {{ $allMembers->count() }} member{{ $allMembers->count() !== 1 ? 's' : '' }}
                </p>
                <div class="text-sm text-gray-500">
                    Last updated: {{ now()->format('h:i A') }}
                </div>
            </div>
        </div>

        <!-- Member Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Department Distribution -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Members by Department</h3>
                <div class="space-y-4">
                    @foreach($departmentDistribution as $dept)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">{{ $dept['name'] }}</span>
                                <span class="font-medium text-gray-900">{{ $dept['count'] }} members ({{ $dept['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $dept['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Status Overview -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Member Status Overview</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-green-600 mb-2">{{ $statusOverview['active_members'] }}</div>
                        <p class="text-gray-700">Active Members</p>
                        <p class="text-xs text-gray-500 mt-1">Can access all SACCO services</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-yellow-600 mb-2">{{ $statusOverview['pending_approval'] }}</div>
                        <p class="text-gray-700">Pending Approval</p>
                        <p class="text-xs text-gray-500 mt-1">Awaiting your review</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-red-600 mb-2">{{ $statusOverview['loan_defaulters'] }}</div>
                        <p class="text-gray-700">Loan Defaulters</p>
                        <p class="text-xs text-gray-500 mt-1">Behind on payments</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-blue-600 mb-2">{{ $statusOverview['active_loans'] }}</div>
                        <p class="text-gray-700">Active Loans</p>
                        <p class="text-xs text-gray-500 mt-1">Total KES {{ number_format($stats['total_loan_amount']) }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Member Details Modal -->
    <div id="memberDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Member Details</h3>
                    <button onclick="closeMemberDetails()" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
                <p class="text-gray-500 text-sm mt-1" id="modalMemberNumber"></p>
            </div>

            <div class="p-6">
                <div id="memberDetailsContent"></div>
            </div>
        </div>
    </div>

    <!-- Approval Confirmation Modal -->
    <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md">
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="approvalTitle">Approve Member</h3>
                <p class="text-gray-500 text-sm mt-1" id="approvalMessage"></p>
            </div>

            <div class="p-6 space-y-4">
                <div id="rejectionReason" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                    <textarea id="rejectionComments" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Provide reason for rejection..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeApprovalModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">Cancel</button>
                    <button onclick="confirmApproval()" id="confirmApproveBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition hidden">✅ Approve</button>
                    <button onclick="confirmRejection()" id="confirmRejectBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition hidden">❌ Reject</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // State variables
        let currentMemberId = null;
        let approvalAction = '';
        let allMembers = @json($allMembers);

        // Search and filter functionality
        function filterMembers() {
            const searchTerm = document.getElementById('searchMembers').value.toLowerCase();
            const department = document.getElementById('filterDepartment').value;
            const status = document.getElementById('filterStatus').value;

            let filtered = allMembers.filter(member => {
                const matchesSearch =
                    member.name.toLowerCase().includes(searchTerm) ||
                    member.employee_number.toLowerCase().includes(searchTerm) ||
                    member.email.toLowerCase().includes(searchTerm) ||
                    member.department.toLowerCase().includes(searchTerm);

                const matchesDept = department ? member.department === department : true;
                const matchesStatus = status ? member.status === status : true;

                return matchesSearch && matchesDept && matchesStatus;
            });

            renderMembers(filtered);
        }

        // Render members table
        function renderMembers(filteredMembers) {
            const tbody = document.getElementById('membersTableBody');
            tbody.innerHTML = '';

            filteredMembers.forEach((member, index) => {
                const joinedDate = new Date(member.date_joined);
                const row = document.createElement('tr');
                row.className = 'border-t border-gray-300 hover:bg-gray-50';
                
                row.innerHTML = `
                    <td class="px-4 py-3 text-gray-900 font-medium border border-gray-300 text-center">${index + 1}</td>
                    <td class="px-4 py-3 font-mono text-gray-900 border border-gray-300 whitespace-nowrap">${member.employee_number}</td>
                    <td class="px-4 py-3 border border-gray-300 whitespace-nowrap">
                        <div class="font-medium text-gray-900">${member.name}</div>
                    </td>
                    <td class="px-4 py-3 border border-gray-300">
                        <div class="text-gray-700 truncate max-w-[150px]">${member.email}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-700 border border-gray-300">${member.department}</td>
                    <td class="px-4 py-3 text-gray-700 border border-gray-300">${member.position}</td>
                    <td class="px-4 py-3 border border-gray-300 text-right whitespace-nowrap">
                        <div class="font-medium text-gray-900">${member.savings.toLocaleString()}</div>
                    </td>
                    <td class="px-4 py-3 border border-gray-300 text-right whitespace-nowrap">
                        <div class="font-medium text-gray-900">${member.loan_eligibility.toLocaleString()}</div>
                    </td>
                    <td class="px-4 py-3 border border-gray-300">
                        ${member.status === 'active' ? 
                            '<span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium whitespace-nowrap">Active</span>' : 
                         member.status === 'pending' ? 
                            '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium whitespace-nowrap">Pending</span>' : 
                            '<span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium whitespace-nowrap">Inactive</span>'}
                        ${member.loan_status === 'default' ? 
                            '<div class="mt-1"><span class="px-2 py-0.5 bg-red-100 text-red-800 rounded text-xs whitespace-nowrap">Default</span></div>' : ''}
                    </td>
                    <td class="px-4 py-3 border border-gray-300">
                        <div class="flex gap-1">
                            <button onclick="viewMemberDetails(${member.id})" class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-xs font-medium border border-blue-200 whitespace-nowrap">View</button>
                            ${member.status === 'pending' ? `
                                <button onclick="approveMember(${member.id})" class="px-2 py-1 bg-green-50 text-green-700 hover:bg-green-100 rounded text-xs font-medium border border-green-200 whitespace-nowrap">Approve</button>
                                <button onclick="rejectMember(${member.id})" class="px-2 py-1 bg-red-50 text-red-700 hover:bg-red-100 rounded text-xs font-medium border border-red-200 whitespace-nowrap">Reject</button>
                            ` : ''}
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            document.getElementById('paginationInfo').textContent = `${filteredMembers.length} member${filteredMembers.length !== 1 ? 's' : ''}`;
        }

        // View member details
        async function viewMemberDetails(id) {
            try {
                const response = await fetch(`/chairman/member/${id}/details`);
                const data = await response.json();

                if (data.success) {
                    const member = data.member;
                    currentMemberId = id;
                    document.getElementById('modalMemberNumber').textContent = `Member: ${member.employee_number}`;

                    const detailsHtml = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">Full Name</p>
                                        <p class="font-medium text-gray-900">${member.name}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email Address</p>
                                        <p class="font-medium text-gray-900">${member.email}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone Number</p>
                                        <p class="font-medium text-gray-900">${member.phone}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Date Joined</p>
                                        <p class="font-medium text-gray-900">${member.date_joined}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">Department</p>
                                        <p class="font-medium text-gray-900">${member.department}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Position</p>
                                        <p class="font-medium text-gray-900">${member.position}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Employee Number</p>
                                        <p class="font-medium text-gray-900">${member.employee_number}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Member Status</p>
                                        <p class="font-medium ${member.status === 'active' ? 'text-green-600' : member.status === 'pending' ? 'text-yellow-600' : 'text-red-600'}">${member.status.charAt(0).toUpperCase() + member.status.slice(1)}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="md:col-span-2">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Financial Summary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Total Savings</p>
                                        <p class="text-2xl font-semibold text-gray-900">KES ${member.savings.toLocaleString()}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Loan Eligibility</p>
                                        <p class="text-2xl font-semibold text-gray-900">KES ${member.loan_eligibility.toLocaleString()}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500">Loan Status</p>
                                        <p class="text-xl font-semibold ${member.loan_status === 'active' ? 'text-blue-600' : member.loan_status === 'default' ? 'text-red-600' : 'text-gray-600'}">${member.loan_status_text}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            ${member.status === 'pending' ? `
                            <div class="md:col-span-2 pt-6 border-t">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Approval Actions</h4>
                                <div class="flex space-x-4">
                                    <button onclick="approveMember(${member.id})" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                                        <span class="mr-2">✅</span> Approve Member
                                    </button>
                                    <button onclick="rejectMember(${member.id})" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                                        <span class="mr-2">❌</span> Reject Member
                                    </button>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    `;

                    document.getElementById('memberDetailsContent').innerHTML = detailsHtml;
                    document.getElementById('memberDetailsModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading member details:', error);
                alert('Error loading member details');
            }
        }

        function closeMemberDetails() {
            document.getElementById('memberDetailsModal').classList.add('hidden');
            currentMemberId = null;
        }

        // Approve member
        function approveMember(id) {
            const member = allMembers.find(m => m.id === id);
            if (!member) return;

            currentMemberId = id;
            approvalAction = 'approve';

            document.getElementById('approvalTitle').textContent = 'Approve Member';
            document.getElementById('approvalMessage').textContent = `Approve ${member.name} (${member.employee_number}) as a SACCO member?`;
            document.getElementById('rejectionReason').classList.add('hidden');
            document.getElementById('confirmApproveBtn').classList.remove('hidden');
            document.getElementById('confirmRejectBtn').classList.add('hidden');

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        // Reject member
        function rejectMember(id) {
            const member = allMembers.find(m => m.id === id);
            if (!member) return;

            currentMemberId = id;
            approvalAction = 'reject';

            document.getElementById('approvalTitle').textContent = 'Reject Member';
            document.getElementById('approvalMessage').textContent = `Reject ${member.name}'s membership application?`;
            document.getElementById('rejectionReason').classList.remove('hidden');
            document.getElementById('confirmApproveBtn').classList.add('hidden');
            document.getElementById('confirmRejectBtn').classList.remove('hidden');

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        function closeApprovalModal() {
            document.getElementById('approvalModal').classList.add('hidden');
            currentMemberId = null;
            approvalAction = '';
            document.getElementById('rejectionComments').value = '';
        }

        async function confirmApproval() {
            if (!currentMemberId) return;

            try {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('action', 'approve');
                formData.append('notes', '');

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Failed to approve member');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error approving member');
            }
        }

        async function confirmRejection() {
            if (!currentMemberId) return;

            const reason = document.getElementById('rejectionComments').value;
            if (!reason.trim()) {
                alert('Please provide a reason for rejection');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('action', 'reject');
                formData.append('rejection_reason', reason);

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Failed to reject member');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error rejecting member');
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('searchMembers').addEventListener('input', filterMembers);
            document.getElementById('filterDepartment').addEventListener('change', filterMembers);
            document.getElementById('filterStatus').addEventListener('change', filterMembers);

            window.onclick = function (event) {
                const detailsModal = document.getElementById('memberDetailsModal');
                const approvalModal = document.getElementById('approvalModal');

                if (event.target == detailsModal) closeMemberDetails();
                if (event.target == approvalModal) closeApprovalModal();
            }
        });
    </script>
@endsection