@extends('components.dashboard-layout')

@section('title', 'Register New Member')

@section('content')
<div class="max-w-5xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-user-plus mr-2 text-green-600"></i> Register New Member
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Register a new employee into the SACCO system
            </p>
        </div>
        <a href="{{ route('secretary.members') }}" 
           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <form action="{{ route('secretary.members.store') }}" method="POST" class="space-y-4 p-4 sm:p-6">
            @csrf
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-user-circle mr-2 text-green-600"></i> Personal Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="employee_number" class="block text-xs font-medium text-gray-700 mb-1">
                            Employee Number *
                        </label>
                        <input type="text" name="employee_number" id="employee_number" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('employee_number') border-red-300 @enderror" 
                               value="{{ old('employee_number') }}" required>
                        @error('employee_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="national_id" class="block text-xs font-medium text-gray-700 mb-1">
                            National ID *
                        </label>
                        <input type="text" name="national_id" id="national_id" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('national_id') border-red-300 @enderror" 
                               value="{{ old('national_id') }}" required maxlength="8">
                        @error('national_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('name') border-red-300 @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email Address *
                        </label>
                        <input type="email" name="email" id="email" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('email') border-red-300 @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-medium text-gray-700 mb-1">
                            Phone Number *
                        </label>
                        <input type="text" name="phone" id="phone" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-300 @enderror" 
                               value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-xs font-medium text-gray-700 mb-1">
                            Date of Birth *
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('date_of_birth') border-red-300 @enderror" 
                               value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-briefcase mr-2 text-green-600"></i> Employment Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="department" class="block text-xs font-medium text-gray-700 mb-1">
                            Department *
                        </label>
                        <select name="department" id="department" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 bg-white appearance-none @error('department') border-red-300 @enderror" 
                               required>
                            <option value="">Select Department</option>
                            <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Human Resources" {{ old('department') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                            <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                            <option value="Operations" {{ old('department') == 'Operations' ? 'selected' : '' }}>Operations</option>
                            <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Sales" {{ old('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Customer Service" {{ old('department') == 'Customer Service' ? 'selected' : '' }}>Customer Service</option>
                            <option value="Procurement" {{ old('department') == 'Procurement' ? 'selected' : '' }}>Procurement</option>
                            <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration</option>
                            <option value="Research & Development" {{ old('department') == 'Research & Development' ? 'selected' : '' }}>Research & Development</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                        @error('department')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-xs font-medium text-gray-700 mb-1">
                            Position *
                        </label>
                        <input type="text" name="position" id="position" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('position') border-red-300 @enderror" 
                               value="{{ old('position') }}" required>
                        @error('position')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_date" class="block text-xs font-medium text-gray-700 mb-1">
                            Employment Date *
                        </label>
                        <input type="date" name="employment_date" id="employment_date" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('employment_date') border-red-300 @enderror" 
                               value="{{ old('employment_date') }}" required>
                        @error('employment_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="monthly_salary" class="block text-xs font-medium text-gray-700 mb-1">
                            Monthly Salary (KES) *
                        </label>
                        <input type="number" name="monthly_salary" id="monthly_salary" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('monthly_salary') border-red-300 @enderror" 
                               value="{{ old('monthly_salary') }}" min="0" step="0.01" required>
                        @error('monthly_salary')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SACCO Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-piggy-bank mr-2 text-green-600"></i> SACCO Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="monthly_savings" class="block text-xs font-medium text-gray-700 mb-1">
                            Monthly Savings (KES) *
                        </label>
                        <input type="number" name="monthly_savings" id="monthly_savings" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('monthly_savings') border-red-300 @enderror" 
                               value="{{ old('monthly_savings') }}" min="0" step="0.01" required>
                        @error('monthly_savings')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Deducted from salary monthly</p>
                    </div>

                    <div>
                        <label for="initial_topup" class="block text-xs font-medium text-gray-700 mb-1">
                            Initial Topup (KES)
                        </label>
                        <input type="number" name="initial_topup" id="initial_topup" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('initial_topup') border-red-300 @enderror" 
                               value="{{ old('initial_topup') }}" min="0" step="0.01">
                        @error('initial_topup')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Optional initial deposit</p>
                    </div>

                    
                </div>
            </div>

            <!-- Next of Kin Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-users mr-2 text-green-600"></i> Next of Kin (Optional)
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="next_of_kin_name" class="block text-xs font-medium text-gray-700 mb-1">
                            Name
                        </label>
                        <input type="text" name="next_of_kin_name" id="next_of_kin_name" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('next_of_kin_name') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_name') }}">
                        @error('next_of_kin_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_relationship" class="block text-xs font-medium text-gray-700 mb-1">
                            Relationship
                        </label>
                        <select name="next_of_kin_relationship" id="next_of_kin_relationship" 
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 bg-white appearance-none @error('next_of_kin_relationship') border-red-300 @enderror">
                            <option value="">Select Relationship</option>
                            <option value="Spouse" {{ old('next_of_kin_relationship') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="Parent" {{ old('next_of_kin_relationship') == 'Parent' ? 'selected' : '' }}>Parent</option>
                            <option value="Sibling" {{ old('next_of_kin_relationship') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="Child" {{ old('next_of_kin_relationship') == 'Child' ? 'selected' : '' }}>Child</option>
                            <option value="Other" {{ old('next_of_kin_relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('next_of_kin_relationship')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_phone" class="block text-xs font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>
                        <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('next_of_kin_phone') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_phone') }}">
                        @error('next_of_kin_phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_id" class="block text-xs font-medium text-gray-700 mb-1">
                            National ID
                        </label>
                        <input type="text" name="next_of_kin_id" id="next_of_kin_id" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 @error('next_of_kin_id') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_id') }}">
                        @error('next_of_kin_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('secretary.members') }}" 
                       class="px-3 py-2 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-user-plus mr-1"></i> Register Member
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Improved dropdown styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    select:focus {
        outline: none;
        ring: 1px;
        ring-color: #059669;
    }
    
    /* Better focus states */
    input:focus, select:focus {
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
    }
    
    /* Compact form spacing */
    .form-group {
        margin-bottom: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Format phone number to Kenyan format
    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 0) {
            // Keep only last 9 digits and prepend with 254
            value = '254' + value.substring(value.length - 9);
        }
        input.value = value;
    }

    // Format national ID (Kenyan format: 8 digits)
    function formatNationalId(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        input.value = value;
    }

    // Auto-calculate loan eligibility
    function calculateLoanEligibility() {
        const monthlySavings = parseFloat(document.getElementById('monthly_savings').value) || 0;
        const loanEligibility = (monthlySavings * 12) * 1.5; // Annual savings × 1.5
        
        // You can display this somewhere if needed
        console.log('Loan Eligibility:', loanEligibility);
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone');
        const nokPhoneInput = document.getElementById('next_of_kin_phone');
        const nationalIdInput = document.getElementById('national_id');
        const nokIdInput = document.getElementById('next_of_kin_id');
        const monthlySavingsInput = document.getElementById('monthly_savings');
        
        if (phoneInput) phoneInput.addEventListener('input', () => formatPhoneNumber(phoneInput));
        if (nokPhoneInput) nokPhoneInput.addEventListener('input', () => formatPhoneNumber(nokPhoneInput));
        if (nationalIdInput) nationalIdInput.addEventListener('input', () => formatNationalId(nationalIdInput));
        if (nokIdInput) nokIdInput.addEventListener('input', () => formatNationalId(nokIdInput));
        if (monthlySavingsInput) monthlySavingsInput.addEventListener('input', calculateLoanEligibility);
    });
</script>
@endpush