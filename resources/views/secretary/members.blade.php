@extends('components.dashboard-layout')

@section('title', 'Member Management')

@section('content')
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Management</h1>
                    <p class="text-gray-500 mt-1">
                        Add new members and manage existing member information
                    </p>
                </div>
                <div>
                    <button onclick="openAddMemberModal()"
                        class="px-6 py-3 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800 transition flex items-center">
                        <span class="mr-2">+</span> Add New Member
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Members</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">156</p>
                        <p class="text-xs text-gray-400 mt-1">All registered members</p>
                    </div>
                    <div class="text-3xl">👥</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Members</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">148</p>
                        <p class="text-xs text-gray-400 mt-1">Approved and active</p>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending Approval</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">8</p>
                        <p class="text-xs text-gray-400 mt-1">Awaiting chairman</p>
                    </div>
                    <div class="text-3xl">⏳</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">New This Month</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">12</p>
                        <p class="text-xs text-gray-400 mt-1">March registrations</p>
                    </div>
                    <div class="text-3xl">📈</div>
                </div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">All Members</h2>
                <div class="flex space-x-3">
                    <input type="text" placeholder="Search members..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="searchInput">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="membersTable">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Employee #</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Name</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Department</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Position</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Phone</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Status</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y" id="membersTableBody">
                        <!-- Dummy data will be populated by JavaScript -->
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

    </div>

    <!-- Add Member Modal -->
    <div id="addMemberModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b sticky top-0 bg-white">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Add New Member</h3>
                    <button onclick="closeAddMemberModal()" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
                <p class="text-gray-500 text-sm mt-1">Register a new Makamithi employee to the SACCO</p>
            </div>

            <form action="{{ route('secretary.members.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <!-- Personal Information -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number *</label>
                            <input type="text" name="employee_number" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="EMP001">
                            <p class="text-xs text-gray-400 mt-1">This will be their SACCO member number</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">National ID *</label>
                            <input type="text" name="national_id" id="national_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="12345678">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" id="full_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="john@makamithi.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="phone" id="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="0712 345 678">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Employment Details -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                            <select name="department" id="department"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                <option value="">Select Department</option>
                                <option value="Finance">Finance</option>
                                <option value="Operations">Operations</option>
                                <option value="HR">Human Resources</option>
                                <option value="IT">Information Technology</option>
                                <option value="Sales">Sales</option>
                                <option value="Marketing">Marketing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                            <input type="text" name="position" id="position"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="e.g., Accountant">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employment Date *</label>
                            <input type="date" name="employment_date" id="employment_date"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Salary (KES) *</label>
                            <input type="number" name="monthly_salary" id="monthly_salary" step="0.01"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="50000">
                        </div>
                    </div>
                </div>

                <!-- Next of Kin -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Next of Kin Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Next of Kin Name *</label>
                            <input type="text" name="next_of_kin_name" id="next_of_kin_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="Jane Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Relationship *</label>
                            <select name="next_of_kin_relationship" id="next_of_kin_relationship"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                <option value="">Select Relationship</option>
                                <option value="Spouse">Spouse</option>
                                <option value="Parent">Parent</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Child">Child</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Next of Kin Phone *</label>
                            <input type="tel" name="next_of_kin_phone" id="next_of_kin_phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="0712 345 679">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Next of Kin ID Number</label>
                            <input type="text" name="next_of_kin_id" id="next_of_kin_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="Optional">
                        </div>
                    </div>
                </div>

                <!-- Initial Savings -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Initial Savings Setup</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                💰
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Default Savings Rate</p>
                                <p class="text-sm text-gray-500">5% of monthly salary (auto-calculated)</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Savings (KES) *</label>
                                <input type="number" name="monthly_savings" step="0.01" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                    placeholder="2500">
                                <p class="text-xs text-gray-400 mt-1">Will be deducted from payroll</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Initial Top-up
                                    (Optional)</label>
                                <input type="number" name="initial_topup" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                    placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t pt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddMemberModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center">
                        <span class="mr-2">📤</span>
                        Submit for Approval
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="successToast"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50">
        Member added successfully! Waiting for Chairman approval.
    </div>

    <script>
        // Dummy data for members
        const dummyMembers = [
            {
                id: 1,
                employee_number: 'EMP001',
                name: 'John Doe',
                email: 'john@makamithi.com',
                department: 'Finance',
                position: 'Senior Accountant',
                phone: '0712 345 678',
                status: 'approved',
                savings: 150000,
                date_joined: '2023-01-15'
            },
            {
                id: 2,
                employee_number: 'EMP002',
                name: 'Jane Smith',
                email: 'jane@makamithi.com',
                department: 'Human Resources',
                position: 'HR Manager',
                phone: '0712 345 679',
                status: 'approved',
                savings: 120000,
                date_joined: '2023-02-20'
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
                date_joined: '2023-03-10'
            },
            {
                id: 4,
                employee_number: 'EMP004',
                name: 'Mary Wambui',
                email: 'mary@makamithi.com',
                department: 'IT',
                position: 'Software Developer',
                phone: '0712 345 681',
                status: 'approved',
                savings: 180000,
                date_joined: '2023-04-05'
            },
            {
                id: 5,
                employee_number: 'EMP005',
                name: 'Peter Kamau',
                email: 'peter@makamithi.com',
                department: 'Sales',
                position: 'Sales Executive',
                phone: '0712 345 682',
                status: 'approved',
                savings: 95000,
                date_joined: '2023-05-12'
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
                date_joined: '2023-06-18'
            },
            {
                id: 7,
                employee_number: 'EMP007',
                name: 'David Ochieng',
                email: 'david@makamithi.com',
                department: 'Finance',
                position: 'Accountant',
                phone: '0712 345 684',
                status: 'approved',
                savings: 135000,
                date_joined: '2023-07-22'
            },
            {
                id: 8,
                employee_number: 'EMP008',
                name: 'Grace Akinyi',
                email: 'grace@makamithi.com',
                department: 'Operations',
                position: 'Logistics Coordinator',
                phone: '0712 345 685',
                status: 'rejected',
                savings: 80000,
                date_joined: '2023-08-30'
            },
            {
                id: 9,
                employee_number: 'EMP009',
                name: 'James Mutua',
                email: 'james@makamithi.com',
                department: 'IT',
                position: 'System Administrator',
                phone: '0712 345 686',
                status: 'approved',
                savings: 165000,
                date_joined: '2023-09-14'
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
                date_joined: '2023-10-25'
            }
        ];

        // Modal Functions
        function openAddMemberModal() {
            document.getElementById('addMemberModal').classList.remove('hidden');
        }

        function closeAddMemberModal() {
            document.getElementById('addMemberModal').classList.add('hidden');
        }

        // Submit member form (dummy function)
        function submitMemberForm() {
            // Get form values
            const empNumber = document.getElementById('employee_number').value;
            const name = document.getElementById('full_name').value;

            if (!empNumber || !name) {
                alert('Please fill in required fields');
                return;
            }

            // Simulate form submission
            closeAddMemberModal();

            // Show success toast
            const toast = document.getElementById('successToast');
            toast.classList.remove('hidden');

            // Add new member to dummy data (for demo)
            const newMember = {
                id: dummyMembers.length + 1,
                employee_number: empNumber,
                name: name,
                email: document.getElementById('email').value || 'new@makamithi.com',
                department: document.getElementById('department').value || 'General',
                position: document.getElementById('position').value || 'Employee',
                phone: document.getElementById('phone').value || '0712 000 000',
                status: 'pending',
                savings: 0,
                date_joined: new Date().toISOString().split('T')[0]
            };

            dummyMembers.unshift(newMember); // Add to beginning
            renderMembers(); // Refresh table

            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);

            // Clear form
            document.getElementById('addMemberModal').querySelectorAll('input, select').forEach(element => {
                element.value = '';
            });
        }

        // Render members table
        function renderMembers(filteredMembers = dummyMembers) {
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
                                <td class="px-6 py-4 text-gray-700">${member.department}</td>
                                <td class="px-6 py-4 text-gray-700">${member.position}</td>
                                <td class="px-6 py-4 text-gray-700">${member.phone}</td>
                                <td class="px-6 py-4">
                                    ${member.status === 'approved' ?
                        '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✅ Approved</span>' :
                        member.status === 'pending' ?
                            '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳ Pending</span>' :
                            '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">❌ Rejected</span>'}
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="viewMember(${member.id})" class="px-3 py-2 bg-gray-900 text-white rounded-lg text-xs font-medium hover:bg-gray-800 transition mr-2">
                                        View
                                    </button>
                                    <button onclick="editMember(${member.id})" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-50 transition">
                                        Edit
                                    </button>
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
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            let filtered = dummyMembers.filter(member => {
                const matchesSearch =
                    member.name.toLowerCase().includes(searchTerm) ||
                    member.employee_number.toLowerCase().includes(searchTerm) ||
                    member.department.toLowerCase().includes(searchTerm) ||
                    member.email.toLowerCase().includes(searchTerm);

                const matchesStatus = statusFilter ? member.status === statusFilter : true;

                return matchesSearch && matchesStatus;
            });

            renderMembers(filtered);
        }

        // View member details (dummy function)
        function viewMember(id) {
            const member = dummyMembers.find(m => m.id === id);
            if (member) {
                alert(`Member Details:\n\nName: ${member.name}\nEmployee #: ${member.employee_number}\nDepartment: ${member.department}\nPosition: ${member.position}\nEmail: ${member.email}\nPhone: ${member.phone}\nStatus: ${member.status}\nSavings: KES ${member.savings.toLocaleString()}\nDate Joined: ${member.date_joined}`);
            }
        }

        // Edit member (dummy function)
        function editMember(id) {
            const member = dummyMembers.find(m => m.id === id);
            if (member) {
                alert(`Edit Member: ${member.name}\n\nNote: This would open an edit form. For now, this is just a demo.`);
            }
        }

        // Initialize table
        document.addEventListener('DOMContentLoaded', function () {
            renderMembers();

            // Add event listeners for search and filter
            document.getElementById('searchInput').addEventListener('input', filterMembers);
            document.getElementById('statusFilter').addEventListener('change', filterMembers);

            // Close modal when clicking outside
            window.onclick = function (event) {
                const modal = document.getElementById('addMemberModal');
                if (event.target == modal) {
                    closeAddMemberModal();
                }
            }

            // Auto-calculate monthly savings based on salary
            document.getElementById('monthly_salary').addEventListener('input', function () {
                const salary = parseFloat(this.value) || 0;
                const monthlySavings = salary * 0.05; // 5% of salary
                document.getElementById('monthly_savings').value = monthlySavings.toFixed(2);
            });
        });
    </script>
@endsection