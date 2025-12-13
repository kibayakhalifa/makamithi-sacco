@extends('components.dashboard-layout')

@section('title', 'My Profile')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="text-purple-800 mt-2">Manage your personal and account information</p>
                </div>
                <button onclick="document.getElementById('editModal').classList.remove('hidden')"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    ✏️ Edit Profile
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Personal Information -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Contact Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">👤 Personal Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm">Full Name</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Email Address</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->email }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Phone Number</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Date of Birth</p>
                            <p class="text-gray-900 font-semibold mt-1">
                                @if($user->date_of_birth)
                                    {{ $user->date_of_birth->format('d M Y') }}
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">National ID</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->national_id ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Address</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-lg font-bold text-gray-900">💼 Employment Information</h2>
                        <button onclick="document.getElementById('employmentModal').classList.remove('hidden')" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">✏️ Edit</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm">Employee Number</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->employee_number }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Department</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->department ?? 'Not specified' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Position</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $user->position ?? 'Not specified' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Monthly Salary</p>
                            <p class="text-gray-900 font-semibold mt-1">
                                @if($user->monthly_salary)
                                    KES {{ number_format($user->monthly_salary, 2) }}
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Employment Date</p>
                            <p class="text-gray-900 font-semibold mt-1">
                                @if($user->employment_date)
                                    {{ $user->employment_date->format('d M Y') }}
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Next of Kin -->
                @if($user->nextOfKin)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">👨‍👩‍👧 Next of Kin</h2>
                            <button onclick="document.getElementById('nextOfKinModal').classList.remove('hidden')" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">✏️ Edit</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-gray-600 text-sm">Name</p>
                                <p class="text-gray-900 font-semibold mt-1">{{ $user->nextOfKin->name ?? 'Not provided' }}</p>
                            </div>

                            <div>
                                <p class="text-gray-600 text-sm">Relationship</p>
                                <p class="text-gray-900 font-semibold mt-1">
                                    {{ $user->nextOfKin->relationship ?? 'Not specified' }}</p>
                            </div>

                            <div>
                                <p class="text-gray-600 text-sm">Phone Number</p>
                                <p class="text-gray-900 font-semibold mt-1">{{ $user->nextOfKin->phone ?? 'Not provided' }}</p>
                            </div>

                            <div>
                                <p class="text-gray-600 text-sm">National ID</p>
                                <p class="text-gray-900 font-semibold mt-1">
                                    {{ $user->nextOfKin->national_id ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Sidebar: Account Summary -->
            <div class="space-y-6">

                <!-- Account Status -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Account Summary</h3>

                    <div class="space-y-4">
                        <div class="pb-4 border-b">
                            <p class="text-gray-600 text-sm">Member Since</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $accountSummary['member_since'] }}</p>
                        </div>

                        <div class="pb-4 border-b">
                            <p class="text-gray-600 text-sm">Membership Status</p>
                            <p class="text-gray-900 font-semibold mt-1">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    ✓ {{ $accountSummary['membership_status'] }}
                                </span>
                            </p>
                        </div>

                        <div class="pb-4 border-b">
                            <p class="text-gray-600 text-sm">Total Savings</p>
                            <p class="text-2xl font-bold text-green-600">KES
                                {{ number_format($accountSummary['total_savings'], 2) }}</p>
                        </div>

                        <div class="pb-4 border-b">
                            <p class="text-gray-600 text-sm">Loan Qualification</p>
                            <p class="text-2xl font-bold text-blue-600">KES {{ number_format($loanEligibility, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-1">1.5× your savings</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Active Loans</p>
                            <p class="text-2xl font-bold text-purple-600">KES
                                {{ number_format($accountSummary['active_loans'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Savings -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">💳 Monthly Contributions</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Salary Deduction</span>
                            <span class="font-semibold text-gray-900">
                                @if($user->monthly_savings)
                                    KES {{ number_format($user->monthly_savings, 2) }}
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Annual Savings</span>
                            <span class="font-bold text-green-600">
                                @if($user->monthly_savings)
                                    KES {{ number_format($user->monthly_savings * 12, 2) }}
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">⚡ Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('member.savings.index') }}"
                            class="block w-full px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg font-semibold text-center transition">
                            💰 View Savings
                        </a>
                        <a href="{{ route('member.loans.apply') }}"
                            class="block w-full px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-semibold text-center transition">
                            📝 Apply for Loan
                        </a>
                        <a href="{{ route('member.reports.index') }}"
                            class="block w-full px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-semibold text-center transition">
                            📊 View Reports
                        </a>
                    </div>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">🔒 Security</h3>

                    <button onclick="alert('Change password functionality coming soon')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Change Password
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
            <div class="p-6 border-b sticky top-0 bg-white">
                <h2 class="text-xl font-bold text-gray-900">Edit Profile</h2>
                <p class="text-gray-600 text-sm mt-1">Update your personal information</p>
            </div>

            <form action="{{ route('member.profile.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ $user->phone }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">National ID</label>
                        <input type="text" name="national_id" value="{{ $user->national_id }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $user->date_of_birth?->format('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Address</label>
                        <input type="text" name="address" value="{{ $user->address }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Department</label>
                        <input type="text" name="department" value="{{ $user->department }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Position</label>
                        <input type="text" name="position" value="{{ $user->position }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Employment Info Modal -->
    <div id="employmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b sticky top-0 bg-white">
                <h2 class="text-xl font-bold text-gray-900">Update Employment Info</h2>
                <p class="text-gray-600 text-sm mt-1">Update your employment details</p>
            </div>

            <form action="{{ route('member.profile.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="update_employment" value="1">

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Department</label>
                    <input type="text" name="department" value="{{ $user->department }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="e.g., Human Resources">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Position</label>
                    <input type="text" name="position" value="{{ $user->position }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="e.g., Manager">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Monthly Salary (KES)</label>
                    <input type="number" name="monthly_salary" value="{{ $user->monthly_salary }}" step="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="100,000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Employment Date</label>
                    <input type="date" name="employment_date" value="{{ $user->employment_date?->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('employmentModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Next of Kin Modal -->
    @if($user->nextOfKin)
    <div id="nextOfKinModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b sticky top-0 bg-white">
                <h2 class="text-xl font-bold text-gray-900">Update Next of Kin</h2>
                <p class="text-gray-600 text-sm mt-1">Update your next of kin information</p>
            </div>

            <form action="{{ route('member.profile.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="update_nok" value="1">

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Next of Kin Name</label>
                    <input type="text" name="next_of_kin_name" value="{{ $user->nextOfKin->name }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Relationship</label>
                    <select name="next_of_kin_relationship" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="spouse" {{ $user->nextOfKin->relationship === 'spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="parent" {{ $user->nextOfKin->relationship === 'parent' ? 'selected' : '' }}>Parent</option>
                        <option value="sibling" {{ $user->nextOfKin->relationship === 'sibling' ? 'selected' : '' }}>Sibling</option>
                        <option value="child" {{ $user->nextOfKin->relationship === 'child' ? 'selected' : '' }}>Child</option>
                        <option value="other" {{ $user->nextOfKin->relationship === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Phone Number</label>
                    <input type="tel" name="next_of_kin_phone" value="{{ $user->nextOfKin->phone }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">National ID</label>
                    <input type="text" name="next_of_kin_id_number" value="{{ $user->nextOfKin->national_id }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Address (Optional)</label>
                    <input type="text" name="next_of_kin_address" value="{{ $user->nextOfKin->address }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('nextOfKinModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        document.getElementById('employmentModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        @if($user->nextOfKin)
        document.getElementById('nextOfKinModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        @endif
    </script>
@endsection