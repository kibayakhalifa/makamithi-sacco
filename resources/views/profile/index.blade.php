@extends('components.dashboard-layout')

@section('title', 'My Profile')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-gray-900 text-white rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mr-6">
                    <span class="text-4xl text-gray-900 font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold">{{ auth()->user()->name }}</h1>
                    <p class="text-gray-400 mt-1 text-sm md:text-base">
                        Member No: {{ auth()->user()->employee_number ?? 'EMP001' }} • {{ ucfirst(auth()->user()->role) }} • Makamithi Enterprises Ltd
                    </p>
                </div>
            </div>
            <button class="mt-4 md:mt-0 bg-gray-100 text-gray-900 hover:bg-gray-200 px-5 py-2 rounded-lg font-semibold transition">
                ✏️ Edit
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Personal Info -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-5">👤 Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-profile-row label="Full Name" :value="auth()->user()->name" />
                    <x-profile-row label="Email" :value="auth()->user()->email" />
                    <x-profile-row label="Phone Number" value="+254 7XX XXX XXX" />
                    <x-profile-row label="ID Number" value="12345678" />
                    <x-profile-row label="Date of Birth" value="15th June 1985" />
                    <x-profile-row label="Gender" value="Male" />
                    <x-profile-row label="Residential Address" value="123 Main Street, Nairobi, Kenya" full="true" />
                </div>
            </div>

            <!-- Employment Info -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-5">💼 Employment Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-profile-row label="Employee Number" :value="auth()->user()->employee_number ?? 'EMP001'" />
                    <x-profile-row label="Department" value="Finance Department" />
                    <x-profile-row label="Job Title" value="Senior Accountant" />
                    <x-profile-row label="Employment Date" value="15th January 2023" />
                    <x-profile-row label="Monthly Salary" value="KES 85,000.00" bold="true" />
                    <x-profile-row label="Payroll Number" value="PAY-00123" />
                </div>
                <div class="mt-5">
                    <x-summary-row label="Employment Status" value="Active Employee" emphasis="true" />
                </div>
            </div>

            <!-- Next of Kin -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-5">👨‍👩‍👧‍👦 Next of Kin</h2>
                <div class="bg-gray-50 border-l-4 border-gray-300 p-4 mb-4">
                    <p class="text-gray-600 text-sm">
                        ⚠️ Ensure this information is accurate; next of kin is the beneficiary of your savings.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-profile-row label="Full Name" value="Jane Mule" />
                    <x-profile-row label="Relationship" value="Spouse" />
                    <x-profile-row label="Phone Number" value="+254 7XX XXX XXX" />
                    <x-profile-row label="ID Number" value="87654321" />
                    <x-profile-row label="Contact Address" value="Same as member address" full="true" />
                    <x-profile-row label="Additional Notes" value="Primary beneficiary for all SACCO benefits" full="true" />
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">

            <!-- Account Summary -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Account Summary</h3>
                <x-summary-row label="Member Since" value="Jan 2023" />
                <x-summary-row label="Total Savings" value="KES 150,000" emphasis="true" />
                <x-summary-row label="Active Loans" value="KES 75,000" />
                <x-summary-row label="Loan Qualification" value="KES 225,000" />
                <x-summary-row label="Membership Status" value="Active" emphasis="true" />
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6 space-y-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">⚡ Quick Actions</h3>
                @foreach(['Update Profile','Update Next of Kin','Change Password','Update Email','Update Contacts'] as $action)
                    <button class="w-full py-3 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-800 font-semibold transition flex items-center justify-center">
                        {{ $action }}
                    </button>
                @endforeach
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">🔒 Security Settings</h3>
                @foreach([
                    'Two-Factor Authentication' => 'Add extra security to your account',
                    'Email Notifications' => 'Receive updates via email',
                    'SMS Alerts' => 'Get transaction alerts via SMS'
                ] as $setting => $desc)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium">{{ $setting }}</p>
                            <p class="text-sm text-gray-500">{{ $desc }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" @if($setting != 'Two-Factor Authentication') checked @endif>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-gray-900 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                @endforeach
                <button class="w-full py-3 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-800 font-semibold transition">
                    View Login History
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', () => {
            alert('Feature coming soon!');
        });
    });
});
</script>
@endsection
