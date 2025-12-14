

<?php $__env->startSection('title', 'Member Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">👥</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Member Management</h1>
                        <p class="text-gray-500 text-sm md:text-base">Add new members and manage existing member information</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-right">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium">Total Members</p>
                    <p class="text-3xl font-bold text-gray-900">156</p>
                    <p class="text-gray-500 text-xs mt-1">All registered members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Members</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">156</p>
                    <p class="text-gray-500 text-sm mt-1">All registered</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="text-blue-600 text-xl">👥</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Active Members</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">148</p>
                    <p class="text-gray-500 text-sm mt-1">Approved and active</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Pending Approval</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">8</p>
                    <p class="text-gray-500 text-sm mt-1">Awaiting chairman</p>
                </div>
                <div class="bg-orange-50 p-3 rounded-lg">
                    <span class="text-orange-600 text-xl">⏳</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">New This Month</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">12</p>
                    <p class="text-gray-500 text-sm mt-1">March registrations</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="text-purple-600 text-xl">📈</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button onclick="switchTab('all')" id="allTab"
                    class="px-6 py-4 font-medium border-b-2 border-blue-600 text-blue-700 whitespace-nowrap">
                    👥 All Members (156)
                </button>
                <button onclick="switchTab('approved')" id="approvedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Approved (148)
                </button>
                <button onclick="switchTab('pending')" id="pendingTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ⏳ Pending (8)
                </button>
                <button onclick="switchTab('rejected')" id="rejectedTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ❌ Rejected (0)
                </button>
                <button onclick="switchTab('new')" id="newTab"
                    class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    🆕 New This Month (12)
                </button>
            </nav>
        </div>

        <!-- All Members -->
        <div id="allContent" class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">All Members List</h3>
                    <p class="text-gray-500 text-sm">Complete member directory</p>
                </div>
                <div class="flex gap-2">
                    <input type="text" placeholder="Search members..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="searchInput">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="departmentFilter">
                        <option value="">All Departments</option>
                        <option value="Finance">Finance</option>
                        <option value="Operations">Operations</option>
                        <option value="HR">Human Resources</option>
                        <option value="IT">Information Technology</option>
                        <option value="Sales">Sales</option>
                        <option value="Marketing">Marketing</option>
                    </select>
                    <button onclick="openAddMemberModal()"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition flex items-center gap-2">
                        <span>+</span> Add Member
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Member Details
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Employee #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Department
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Position
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Phone
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="membersTableBody">
                        <!-- Dummy data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Approved Members -->
        <div id="approvedContent" class="p-6 hidden">
            <!-- Similar table structure for approved members -->
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Member Details
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Employee #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Department
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Position
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Savings Balance
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Approved members data -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Members -->
        <div id="pendingContent" class="p-6 hidden">
            <!-- Similar table structure for pending members -->
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Member Details
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Employee #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Applied Date
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Days Waiting
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Pending members data -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Member Reports & Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Member Reports</h3>
            <div class="space-y-3">
                <button onclick="generateReport('new_members')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>📊 New Members Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('savings_summary')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>💰 Savings Summary Report</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="generateReport('department_analysis')"
                    class="w-full text-left px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-sm flex justify-between items-center border border-gray-200">
                    <span>🏢 Department Analysis</span>
                    <span class="text-gray-400">→</span>
                </button>
                <button onclick="exportMemberData()"
                    class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 text-green-800 rounded-lg text-sm flex justify-between items-center border border-green-200">
                    <span>💾 Export Member Data (Excel)</span>
                    <span class="text-green-600">→</span>
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button onclick="openAddMemberModal()"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>👤</span> Add New Member
                </button>
                <button onclick="sendWelcomeMessages()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>📧</span> Send Welcome Messages
                </button>
                <button onclick="updateMemberStatuses()"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-sm">
                    <span>🔄</span> Batch Update Status
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Add Member Modal -->
<div id="addMemberModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-200">
    <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Add New Member</h3>
                <button onclick="closeAddMemberModal()"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <span class="text-gray-500 hover:text-gray-700">✕</span>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">Register a new Makamithi employee to the SACCO</p>
        </div>

        <form action="<?php echo e(route('secretary.members.store')); ?>" method="POST" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <!-- Personal Information -->
            <div>
                <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number *</label>
                        <input type="text" name="employee_number" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="EMP001">
                        <p class="text-xs text-gray-400 mt-1">This will be their SACCO member number</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">National ID *</label>
                        <input type="text" name="national_id" id="national_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="12345678">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" id="full_name"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="john@makamithi.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" name="phone" id="phone"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="0712 345 678">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors">
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
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors">
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
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="e.g., Accountant">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Employment Date *</label>
                        <input type="date" name="employment_date" id="employment_date"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Salary (KES) *</label>
                        <input type="number" name="monthly_salary" id="monthly_salary" step="0.01"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
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
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="Jane Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Relationship *</label>
                        <select name="next_of_kin_relationship" id="next_of_kin_relationship"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors">
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
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="0712 345 679">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Next of Kin ID Number</label>
                        <input type="text" name="next_of_kin_id" id="next_of_kin_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                            placeholder="Optional">
                    </div>
                </div>
            </div>

            <!-- Initial Savings -->
            <div class="border-t pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Initial Savings Setup</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
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
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                                placeholder="2500">
                            <p class="text-xs text-gray-400 mt-1">Will be deducted from payroll</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Initial Top-up
                                (Optional)</label>
                            <input type="number" name="initial_topup" step="0.01"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-0 transition-colors"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="border-t pt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAddMemberModal()"
                    class="px-6 py-3 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
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

        filteredMembers.forEach((member, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium border border-gray-300">
                    ${index + 1}
                </td>
                <td class="px-4 py-3 border border-gray-300">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-gray-700 text-sm font-medium">
                                ${member.name.charAt(0).toUpperCase()}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">${member.name}</p>
                            <p class="text-gray-500 text-xs">${member.email}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                    ${member.employee_number}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                    ${member.department}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                    ${member.position}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border border-gray-300">
                    ${member.phone}
                </td>
                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                    ${member.status === 'approved' ?
                        '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full border border-green-200 font-medium">✅ Approved</span>' :
                        member.status === 'pending' ?
                        '<span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full border border-orange-200 font-medium">⏳ Pending</span>' :
                        '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full border border-red-200 font-medium">❌ Rejected</span>'}
                </td>
                <td class="px-4 py-3 whitespace-nowrap border border-gray-300">
                    <div class="flex gap-2">
                        <button onclick="viewMember(${member.id})"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs font-medium">
                            View
                        </button>
                        <button onclick="editMember(${member.id})"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                            Edit
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Search and filter functionality
    function filterMembers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const departmentFilter = document.getElementById('departmentFilter').value;

        let filtered = dummyMembers.filter(member => {
            const matchesSearch =
                member.name.toLowerCase().includes(searchTerm) ||
                member.employee_number.toLowerCase().includes(searchTerm) ||
                member.department.toLowerCase().includes(searchTerm) ||
                member.email.toLowerCase().includes(searchTerm);

            const matchesDepartment = departmentFilter ? member.department === departmentFilter : true;

            return matchesSearch && matchesDepartment;
        });

        renderMembers(filtered);
    }

    // View member details
    function viewMember(id) {
        const member = dummyMembers.find(m => m.id === id);
        if (member) {
            alert(`Member Details:\n\nName: ${member.name}\nEmployee #: ${member.employee_number}\nDepartment: ${member.department}\nPosition: ${member.position}\nEmail: ${member.email}\nPhone: ${member.phone}\nStatus: ${member.status}\nSavings: KES ${member.savings.toLocaleString()}\nDate Joined: ${member.date_joined}`);
        }
    }

    // Edit member
    function editMember(id) {
        const member = dummyMembers.find(m => m.id === id);
        if (member) {
            alert(`Edit Member: ${member.name}\n\nNote: This would open an edit form. For now, this is just a demo.`);
        }
    }

    // Tab switching
    function switchTab(tabName) {
    // Tabs UI
    ['all', 'approved', 'pending', 'rejected', 'new'].forEach(tab => {
        document.getElementById(tab + 'Content').classList.add('hidden');
        document.getElementById(tab + 'Tab').classList.remove(
            'border-b-2', 'border-blue-600', 'text-blue-700'
        );
        document.getElementById(tab + 'Tab').classList.add('text-gray-500');
    });

    document.getElementById(tabName + 'Content').classList.remove('hidden');
    document.getElementById(tabName + 'Tab').classList.add(
        'border-b-2', 'border-blue-600', 'text-blue-700'
    );
    document.getElementById(tabName + 'Tab').classList.remove('text-gray-500');

    // DATA FILTERING
    let filteredMembers = dummyMembers;

    if (tabName === 'approved') {
        filteredMembers = dummyMembers.filter(m => m.status === 'approved');
    } else if (tabName === 'pending') {
        filteredMembers = dummyMembers.filter(m => m.status === 'pending');
    } else if (tabName === 'rejected') {
        filteredMembers = dummyMembers.filter(m => m.status === 'rejected');
    } else if (tabName === 'new') {
        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        filteredMembers = dummyMembers.filter(
            m => new Date(m.date_joined) >= lastMonth
        );
    }

    // RENDER INTO ONE TABLE
    renderMembers(filteredMembers);
}


    // Action functions
    function generateReport(type) {
        alert(`Generating ${type} report...`);
        // window.location.href = `/secretary/reports/members/${type}`;
    }

    function exportMemberData() {
        if (confirm('Export all member data to Excel?')) {
            // window.location.href = '/secretary/members/export';
            alert('Exporting member data...');
        }
    }

    function sendWelcomeMessages() {
        if (confirm('Send welcome messages to all new members?')) {
            alert('Welcome messages sent successfully!');
        }
    }

    function updateMemberStatuses() {
        alert('Opening batch update panel...');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        renderMembers();
        switchTab('all');

        // Add event listeners for search and filter
        document.getElementById('searchInput').addEventListener('input', filterMembers);
        document.getElementById('departmentFilter').addEventListener('change', filterMembers);

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('addMemberModal');
            if (event.target === modal) {
                closeAddMemberModal();
            }
        }

        // Auto-calculate monthly savings based on salary
        document.getElementById('monthly_salary').addEventListener('input', function () {
            const salary = parseFloat(this.value) || 0;
            const monthlySavings = salary * 0.05; // 5% of salary
            document.querySelector('input[name="monthly_savings"]').value = monthlySavings.toFixed(2);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/members.blade.php ENDPATH**/ ?>