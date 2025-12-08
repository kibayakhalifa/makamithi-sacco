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
                    <p class="text-3xl font-semibold mt-2 text-gray-900">156</p>
                    <p class="text-xs text-green-600 mt-1">+12 this month</p>
                </div>
                <div class="text-3xl text-gray-300">👥</div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Active: 148</span>
                    <span>Pending: 8</span>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Pending Approval</p>
                    <p class="text-3xl font-semibold mt-2 text-gray-900">8</p>
                    <p class="text-xs text-yellow-600 mt-1">Require your review</p>
                </div>
                <div class="text-3xl text-yellow-300">⏳</div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Avg: 2 days</span>
                    <span>Oldest: 5 days</span>
                </div>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Active Loans</p>
                    <p class="text-3xl font-semibold mt-2 text-gray-900">24</p>
                    <p class="text-xs text-blue-600 mt-1">KES 3.8M total</p>
                </div>
                <div class="text-3xl text-blue-300">📝</div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Normal: 22</span>
                    <span>Top-up: 2</span>
                </div>
            </div>
        </div>

        <!-- Total Savings -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Savings</p>
                    <p class="text-3xl font-semibold mt-2 text-gray-900">KES 4.5M</p>
                    <p class="text-xs text-green-600 mt-1">+KES 150K this month</p>
                </div>
                <div class="text-3xl text-green-300">💰</div>
            </div>
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Payroll: KES 4.2M</span>
                    <span>Top-up: KES 300K</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Approvals Section -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Pending Member Approvals</h2>
                <p class="text-gray-500 text-sm mt-1">New members submitted by Secretary awaiting your approval</p>
            </div>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                8 pending review
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Employee #</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Name & Details</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Employment Info</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Submitted</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @php
                        $pendingMembers = [
                            [
                                'id' => 1,
                                'employee_number' => 'EMP011',
                                'name' => 'Michael Otieno',
                                'email' => 'michael@makamithi.com',
                                'department' => 'Finance',
                                'position' => 'Accountant',
                                'salary' => 45000,
                                'submitted_by' => 'Secretary Wanjiku',
                                'submitted_date' => now()->subDays(5),
                                'days_pending' => 5
                            ],
                            [
                                'id' => 2,
                                'employee_number' => 'EMP012',
                                'name' => 'Susan Njeru',
                                'email' => 'susan@makamithi.com',
                                'department' => 'Marketing',
                                'position' => 'Marketing Officer',
                                'salary' => 38000,
                                'submitted_by' => 'Secretary Wanjiku',
                                'submitted_date' => now()->subDays(2),
                                'days_pending' => 2
                            ],
                            [
                                'id' => 3,
                                'employee_number' => 'EMP013',
                                'name' => 'David Kiprop',
                                'email' => 'david@makamithi.com',
                                'department' => 'IT',
                                'position' => 'System Administrator',
                                'salary' => 52000,
                                'submitted_by' => 'Secretary Wanjiku',
                                'submitted_date' => now()->subDays(1),
                                'days_pending' => 1
                            ],
                            [
                                'id' => 4,
                                'employee_number' => 'EMP014',
                                'name' => 'Grace Mwende',
                                'email' => 'grace@makamithi.com',
                                'department' => 'HR',
                                'position' => 'HR Assistant',
                                'salary' => 35000,
                                'submitted_by' => 'Secretary Wanjiku',
                                'submitted_date' => now(),
                                'days_pending' => 0
                            ],
                        ];
                    @endphp

                    @foreach($pendingMembers as $member)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-mono text-gray-900">
                            {{ $member['employee_number'] }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $member['name'] }}</div>
                            <div class="text-gray-500 text-xs">{{ $member['email'] }}</div>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $member['days_pending'] == 0 ? 'Today' : $member['days_pending'] . ' days ago' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-700">{{ $member['department'] }}</div>
                            <div class="text-gray-500 text-xs">{{ $member['position'] }}</div>
                            <div class="text-gray-500 text-xs mt-1">KES {{ number_format($member['salary']) }}/month</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-700">{{ $member['submitted_date']->format('d M Y') }}</div>
                            <div class="text-gray-500 text-xs">By {{ $member['submitted_by'] }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button onclick="viewMemberDetails({{ $member['id'] }})"
                                        class="px-3 py-2 bg-gray-900 text-white rounded-lg text-xs font-medium hover:bg-gray-800 transition">
                                    Review
                                </button>
                                <button onclick="approveMember({{ $member['id'] }})"
                                        class="px-3 py-2 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">
                                    Approve
                                </button>
                                <button onclick="rejectMember({{ $member['id'] }})"
                                        class="px-3 py-2 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(count($pendingMembers) === 0)
        <div class="text-center py-12">
            <div class="text-4xl mb-4">✅</div>
            <h3 class="text-lg font-medium text-gray-900">No pending approvals</h3>
            <p class="text-gray-500 mt-1">All members have been approved</p>
        </div>
        @endif
    </div>

    <!-- All Members Section -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">All SACCO Members</h2>
                <p class="text-gray-500 text-sm mt-1">Complete list of Makamithi SACCO members</p>
            </div>
            <div class="flex space-x-3">
                <input type="text" placeholder="Search members..." 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm"
                       id="searchMembers">
                <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="filterDepartment">
                    <option value="">All Departments</option>
                    <option value="Finance">Finance</option>
                    <option value="Operations">Operations</option>
                    <option value="HR">Human Resources</option>
                    <option value="IT">Information Technology</option>
                    <option value="Sales">Sales</option>
                    <option value="Marketing">Marketing</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="membersTable">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Member #</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Name</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Department</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Savings</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Loan Eligibility</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Status</th>
                        <th class="px-6 py-3 text-left text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y" id="membersTableBody">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-8 pt-6 border-t">
            <p class="text-sm text-gray-500" id="paginationInfo">Showing 1 to 10 of 156 members</p>
            <div class="flex space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50" id="prevBtn">
                    Previous
                </button>
                <button class="px-3 py-2 bg-gray-900 text-white rounded-lg text-sm hover:bg-gray-800" id="page1">
                    1
                </button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50" id="nextBtn">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- Member Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Department Distribution -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Members by Department</h3>
            <div class="space-y-4">
                @php
                    $departments = [
                        ['name' => 'Finance', 'count' => 42, 'percentage' => 27],
                        ['name' => 'Operations', 'count' => 38, 'percentage' => 24],
                        ['name' => 'IT', 'count' => 28, 'percentage' => 18],
                        ['name' => 'Sales', 'count' => 22, 'percentage' => 14],
                        ['name' => 'Marketing', 'count' => 18, 'percentage' => 12],
                        ['name' => 'HR', 'count' => 8, 'percentage' => 5],
                    ];
                @endphp

                @foreach($departments as $dept)
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
                    <div class="text-3xl font-semibold text-green-600 mb-2">148</div>
                    <p class="text-gray-700">Active Members</p>
                    <p class="text-xs text-gray-500 mt-1">Can access all SACCO services</p>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-3xl font-semibold text-yellow-600 mb-2">8</div>
                    <p class="text-gray-700">Pending Approval</p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting your review</p>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-3xl font-semibold text-red-600 mb-2">3</div>
                    <p class="text-gray-700">Loan Defaulters</p>
                    <p class="text-xs text-gray-500 mt-1">Behind on payments</p>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-3xl font-semibold text-blue-600 mb-2">24</div>
                    <p class="text-gray-700">Active Loans</p>
                    <p class="text-xs text-gray-500 mt-1">Total KES 3.8M</p>
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
                <button onclick="closeMemberDetails()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1" id="modalMemberNumber"></p>
        </div>

        <div class="p-6">
            <div id="memberDetailsContent">
                <!-- Content will be loaded by JavaScript -->
            </div>
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
                <textarea id="rejectionComments" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                          placeholder="Provide reason for rejection..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button onclick="closeApprovalModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button onclick="confirmApproval()" id="confirmApproveBtn"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition hidden">
                    ✅ Approve Member
                </button>
                <button onclick="confirmRejection()" id="confirmRejectBtn"
                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition hidden">
                    ❌ Reject Member
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Dummy data for members
    const allMembers = [
        {
            id: 1,
            employee_number: 'EMP001',
            name: 'John Doe',
            email: 'john@makamithi.com',
            department: 'Finance',
            position: 'Senior Accountant',
            phone: '0712 345 678',
            status: 'active',
            savings: 150000,
            loan_eligibility: 225000,
            date_joined: '2023-01-15',
            loan_status: 'none'
        },
        {
            id: 2,
            employee_number: 'EMP002',
            name: 'Jane Smith',
            email: 'jane@makamithi.com',
            department: 'Human Resources',
            position: 'HR Manager',
            phone: '0712 345 679',
            status: 'active',
            savings: 120000,
            loan_eligibility: 180000,
            date_joined: '2023-02-20',
            loan_status: 'active'
        },
        {
            id: 3,
            employee_number: 'EMP003',
            name: 'Robert Johnson',
            email: 'robert@makamithi.com',
            department: 'Operations',
            position: 'Operations Manager',
            phone: '0712 345 680',
            status: 'pending',
            savings: 200000,
            loan_eligibility: 300000,
            date_joined: '2023-03-10',
            loan_status: 'none'
        },
        {
            id: 4,
            employee_number: 'EMP004',
            name: 'Mary Wambui',
            email: 'mary@makamithi.com',
            department: 'IT',
            position: 'Software Developer',
            phone: '0712 345 681',
            status: 'active',
            savings: 180000,
            loan_eligibility: 270000,
            date_joined: '2023-04-05',
            loan_status: 'active'
        },
        {
            id: 5,
            employee_number: 'EMP005',
            name: 'Peter Kamau',
            email: 'peter@makamithi.com',
            department: 'Sales',
            position: 'Sales Executive',
            phone: '0712 345 682',
            status: 'active',
            savings: 95000,
            loan_eligibility: 142500,
            date_joined: '2023-05-12',
            loan_status: 'default'
        },
        {
            id: 6,
            employee_number: 'EMP006',
            name: 'Sarah Mwangi',
            email: 'sarah@makamithi.com',
            department: 'Marketing',
            position: 'Marketing Officer',
            phone: '0712 345 683',
            status: 'pending',
            savings: 110000,
            loan_eligibility: 165000,
            date_joined: '2023-06-18',
            loan_status: 'none'
        },
        {
            id: 7,
            employee_number: 'EMP007',
            name: 'David Ochieng',
            email: 'david@makamithi.com',
            department: 'Finance',
            position: 'Accountant',
            phone: '0712 345 684',
            status: 'active',
            savings: 135000,
            loan_eligibility: 202500,
            date_joined: '2023-07-22',
            loan_status: 'completed'
        },
        {
            id: 8,
            employee_number: 'EMP008',
            name: 'Grace Akinyi',
            email: 'grace@makamithi.com',
            department: 'Operations',
            position: 'Logistics Coordinator',
            phone: '0712 345 685',
            status: 'inactive',
            savings: 80000,
            loan_eligibility: 120000,
            date_joined: '2023-08-30',
            loan_status: 'none'
        },
        {
            id: 9,
            employee_number: 'EMP009',
            name: 'James Mutua',
            email: 'james@makamithi.com',
            department: 'IT',
            position: 'System Administrator',
            phone: '0712 345 686',
            status: 'active',
            savings: 165000,
            loan_eligibility: 247500,
            date_joined: '2023-09-14',
            loan_status: 'active'
        },
        {
            id: 10,
            employee_number: 'EMP010',
            name: 'Lucy Chebet',
            email: 'lucy@makamithi.com',
            department: 'Human Resources',
            position: 'Recruitment Officer',
            phone: '0712 345 687',
            status: 'pending',
            savings: 105000,
            loan_eligibility: 157500,
            date_joined: '2023-10-25',
            loan_status: 'none'
        }
    ];

    // State variables
    let currentMemberId = null;
    let approvalAction = ''; // 'approve' or 'reject'

    // Render members table
    function renderMembers(filteredMembers = allMembers) {
        const tbody = document.getElementById('membersTableBody');
        tbody.innerHTML = '';
        
        filteredMembers.forEach(member => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition';
            row.innerHTML = `
                <td class="px-6 py-4 font-mono text-gray-900">${member.employee_number}</td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">${member.name}</div>
                    <div class="text-gray-500 text-xs">${member.email}</div>
                </td>
                <td class="px-6 py-4 text-gray-700">
                    ${member.department}
                    <div class="text-gray-500 text-xs">${member.position}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">KES ${member.savings.toLocaleString()}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">KES ${member.loan_eligibility.toLocaleString()}</div>
                    <div class="text-gray-500 text-xs">1.5× savings rule</div>
                </td>
                <td class="px-6 py-4">
                    ${member.status === 'active' ? 
                        '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✅ Active</span>' :
                        member.status === 'pending' ?
                        '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳ Pending</span>' :
                        '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">❌ Inactive</span>'}
                    ${member.loan_status === 'default' ? 
                        '<div class="mt-1"><span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">⚠️ Defaulting</span></div>' : ''}
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <button onclick="viewMemberDetails(${member.id})" 
                                class="px-3 py-2 bg-gray-900 text-white rounded-lg text-xs font-medium hover:bg-gray-800 transition">
                            View
                        </button>
                        ${member.status === 'pending' ? `
                            <button onclick="approveMember(${member.id})" 
                                    class="px-3 py-2 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">
                                Approve
                            </button>
                            <button onclick="rejectMember(${member.id})" 
                                    class="px-3 py-2 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition">
                                Reject
                            </button>
                        ` : ''}
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        // Update pagination info
        document.getElementById('paginationInfo').textContent = 
            `Showing 1 to ${filteredMembers.length} of ${filteredMembers.length} members`;
    }

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

    // View member details
    function viewMemberDetails(id) {
        const member = allMembers.find(m => m.id === id);
        if (!member) return;
        
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
                            <p class="font-medium ${member.status === 'active' ? 'text-green-600' : member.status === 'pending' ? 'text-yellow-600' : 'text-red-600'}">
                                ${member.status.charAt(0).toUpperCase() + member.status.slice(1)}
                            </p>
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
                            <p class="text-xs text-gray-500 mt-1">Based on 1.5× savings rule</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Loan Status</p>
                            <p class="text-xl font-semibold ${member.loan_status === 'active' ? 'text-blue-600' : member.loan_status === 'default' ? 'text-red-600' : 'text-gray-600'}">
                                ${member.loan_status === 'active' ? 'Active Loan' : 
                                  member.loan_status === 'default' ? 'Defaulting' : 
                                  member.loan_status === 'completed' ? 'Loan Completed' : 'No Active Loan'}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                ${member.status === 'pending' ? `
                <div class="md:col-span-2 pt-6 border-t">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Approval Actions</h4>
                    <div class="flex space-x-4">
                        <button onclick="approveMember(${member.id})"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                            <span class="mr-2">✅</span>
                            Approve Member
                        </button>
                        <button onclick="rejectMember(${member.id})"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                            <span class="mr-2">❌</span>
                            Reject Member
                        </button>
                        <button onclick="requestMoreInfo(${member.id})"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                            Request More Info
                        </button>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('memberDetailsContent').innerHTML = detailsHtml;
        document.getElementById('memberDetailsModal').classList.remove('hidden');
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

    function confirmApproval() {
        if (!currentMemberId) return;
        
        // Update member status in dummy data
        const memberIndex = allMembers.findIndex(m => m.id === currentMemberId);
        if (memberIndex !== -1) {
            allMembers[memberIndex].status = 'active';
        }
        
        // Show success message
        alert('Member approved successfully!');
        
        // Refresh table
        renderMembers();
        
        // Close modals
        closeApprovalModal();
        closeMemberDetails();
    }

    function confirmRejection() {
        if (!currentMemberId) return;
        
        const reason = document.getElementById('rejectionComments').value;
        if (!reason.trim()) {
            alert('Please provide a reason for rejection');
            return;
        }
        
        // Update member status in dummy data
        const memberIndex = allMembers.findIndex(m => m.id === currentMemberId);
        if (memberIndex !== -1) {
            allMembers[memberIndex].status = 'inactive';
        }
        
        // Show success message
        alert(`Member rejected. Reason: ${reason}`);
        
        // Refresh table
        renderMembers();
        
        // Close modals
        closeApprovalModal();
        closeMemberDetails();
    }

    function requestMoreInfo(id) {
        const member = allMembers.find(m => m.id === id);
        if (!member) return;
        
        alert(`Request sent to Secretary for more information about ${member.name}`);
        closeMemberDetails();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderMembers();
        
        // Add event listeners for search and filter
        document.getElementById('searchMembers').addEventListener('input', filterMembers);
        document.getElementById('filterDepartment').addEventListener('change', filterMembers);
        document.getElementById('filterStatus').addEventListener('change', filterMembers);
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            const detailsModal = document.getElementById('memberDetailsModal');
            const approvalModal = document.getElementById('approvalModal');
            
            if (event.target == detailsModal) {
                closeMemberDetails();
            }
            if (event.target == approvalModal) {
                closeApprovalModal();
            }
        }
    });
</script>

<style>
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .progress-bar {
        height: 0.5rem;
        border-radius: 0.25rem;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #10b981);
    }
</style>
@endsection