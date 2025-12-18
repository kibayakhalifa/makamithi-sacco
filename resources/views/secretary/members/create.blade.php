{{-- resources/views/secretary/members/create.blade.php --}}
@extends('components.dashboard-layout')

@section('title', 'Register New Member')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <i class="fas fa-user-plus mr-2"></i> Register New Member
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Register a new employee into the SACCO system
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('secretary.members') }}" 
               class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-arrow-left mr-2"></i> Back to Members
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('secretary.members.store') }}" method="POST" class="space-y-6 p-6">
            @csrf
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-user-circle mr-2"></i> Personal Information
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="employee_number" class="block text-sm font-medium text-gray-700">
                            Employee Number *
                        </label>
                        <input type="text" name="employee_number" id="employee_number" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('employee_number') border-red-300 @enderror" 
                               value="{{ old('employee_number') }}" required>
                        @error('employee_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="national_id" class="block text-sm font-medium text-gray-700">
                            National ID *
                        </label>
                        <input type="text" name="national_id" id="national_id" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('national_id') border-red-300 @enderror" 
                               value="{{ old('national_id') }}" required>
                        @error('national_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address *
                        </label>
                        <input type="email" name="email" id="email" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Phone Number *
                        </label>
                        <input type="text" name="phone" id="phone" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror" 
                               value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                            Date of Birth *
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('date_of_birth') border-red-300 @enderror" 
                               value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-briefcase mr-2"></i> Employment Information
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700">
                            Department *
                        </label>
                        <input type="text" name="department" id="department" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('department') border-red-300 @enderror" 
                               value="{{ old('department') }}" required>
                        @error('department')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">
                            Position *
                        </label>
                        <input type="text" name="position" id="position" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('position') border-red-300 @enderror" 
                               value="{{ old('position') }}" required>
                        @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_date" class="block text-sm font-medium text-gray-700">
                            Employment Date *
                        </label>
                        <input type="date" name="employment_date" id="employment_date" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('employment_date') border-red-300 @enderror" 
                               value="{{ old('employment_date') }}" required>
                        @error('employment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="monthly_salary" class="block text-sm font-medium text-gray-700">
                            Monthly Salary (KES) *
                        </label>
                        <input type="number" name="monthly_salary" id="monthly_salary" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('monthly_salary') border-red-300 @enderror" 
                               value="{{ old('monthly_salary') }}" min="0" step="0.01" required>
                        @error('monthly_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SACCO Information -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-piggy-bank mr-2"></i> SACCO Information
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="monthly_savings" class="block text-sm font-medium text-gray-700">
                            Monthly Savings (KES) *
                        </label>
                        <input type="number" name="monthly_savings" id="monthly_savings" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('monthly_savings') border-red-300 @enderror" 
                               value="{{ old('monthly_savings') }}" min="0" step="0.01" required>
                        @error('monthly_savings')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">This amount will be deducted from salary monthly</p>
                    </div>

                    <div>
                        <label for="initial_topup" class="block text-sm font-medium text-gray-700">
                            Initial Topup (KES)
                        </label>
                        <input type="number" name="initial_topup" id="initial_topup" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('initial_topup') border-red-300 @enderror" 
                               value="{{ old('initial_topup') }}" min="0" step="0.01">
                        @error('initial_topup')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Optional initial deposit</p>
                    </div>
                </div>
            </div>

            <!-- Next of Kin Information -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-users mr-2"></i> Next of Kin Information (Optional)
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="next_of_kin_name" class="block text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <input type="text" name="next_of_kin_name" id="next_of_kin_name" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('next_of_kin_name') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_name') }}">
                        @error('next_of_kin_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_relationship" class="block text-sm font-medium text-gray-700">
                            Relationship
                        </label>
                        <select name="next_of_kin_relationship" id="next_of_kin_relationship" 
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('next_of_kin_relationship') border-red-300 @enderror">
                            <option value="">Select Relationship</option>
                            <option value="Spouse" {{ old('next_of_kin_relationship') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="Parent" {{ old('next_of_kin_relationship') == 'Parent' ? 'selected' : '' }}>Parent</option>
                            <option value="Sibling" {{ old('next_of_kin_relationship') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="Child" {{ old('next_of_kin_relationship') == 'Child' ? 'selected' : '' }}>Child</option>
                            <option value="Other" {{ old('next_of_kin_relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('next_of_kin_relationship')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_phone" class="block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>
                        <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('next_of_kin_phone') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_phone') }}">
                        @error('next_of_kin_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_id" class="block text-sm font-medium text-gray-700">
                            National ID
                        </label>
                        <input type="text" name="next_of_kin_id" id="next_of_kin_id" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('next_of_kin_id') border-red-300 @enderror" 
                               value="{{ old('next_of_kin_id') }}">
                        @error('next_of_kin_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('secretary.members') }}" 
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-user-plus mr-2"></i> Register Member
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-calculate loan eligibility
    document.getElementById('monthly_savings').addEventListener('input', function() {
        const monthlySavings = parseFloat(this.value) || 0;
        const initialTopup = parseFloat(document.getElementById('initial_topup').value) || 0;
        const loanEligibility = (monthlySavings + initialTopup) * 1.5;
        
        // Optional: Display loan eligibility somewhere
        const eligibilityElement = document.getElementById('loanEligibility');
        if (eligibilityElement) {
            eligibilityElement.textContent = `KES ${loanEligibility.toFixed(2)}`;
        }
    });
</script>
@endpush