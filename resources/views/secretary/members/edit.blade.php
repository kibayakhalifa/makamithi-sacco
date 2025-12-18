@extends('components.dashboard-layout')

@section('title', 'Edit Member - ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <i class="fas fa-user-edit mr-2"></i> Edit Member: {{ $user->name }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Employee #: {{ $user->employee_number }} | Status: 
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                    @if($user->sacco_status === 'active') bg-green-100 text-green-800
                    @elseif($user->sacco_status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($user->sacco_status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($user->sacco_status) }}
                </span>
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('secretary.members.show', $user) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-eye mr-2"></i> View Details
            </a>
            <a href="{{ route('secretary.members') }}" 
               class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-arrow-left mr-2"></i> Back to Members
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('secretary.members.update', $user) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-user-circle mr-2"></i> Personal Information
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror" 
                               value="{{ old('name', $user->name) }}" required>
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
                               value="{{ old('email', $user->email) }}" required>
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
                               value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Date of Birth
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ date('F j, Y', strtotime($user->date_of_birth)) }}
                        </div>
                        <p class="text-xs text-gray-500">Date of birth cannot be changed</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Employee Number
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ $user->employee_number }}
                        </div>
                        <p class="text-xs text-gray-500">Employee number cannot be changed</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            National ID
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ $user->national_id }}
                        </div>
                        <p class="text-xs text-gray-500">National ID cannot be changed</p>
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
                               value="{{ old('department', $user->department) }}" required>
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
                               value="{{ old('position', $user->position) }}" required>
                        @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Employment Date
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ date('F j, Y', strtotime($user->employment_date)) }}
                        </div>
                        <p class="text-xs text-gray-500">Employment date cannot be changed</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Years of Service
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($user->employment_date)->diffInYears() }} years
                        </div>
                    </div>

                    <div>
                        <label for="monthly_salary" class="block text-sm font-medium text-gray-700">
                            Monthly Salary (KES) *
                        </label>
                        <input type="number" name="monthly_salary" id="monthly_salary" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('monthly_salary') border-red-300 @enderror" 
                               value="{{ old('monthly_salary', $user->monthly_salary) }}" min="0" step="0.01" required>
                        @error('monthly_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="monthly_savings" class="block text-sm font-medium text-gray-700">
                            Monthly Savings (KES) *
                        </label>
                        <input type="number" name="monthly_savings" id="monthly_savings" 
                               class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('monthly_savings') border-red-300 @enderror" 
                               value="{{ old('monthly_savings', $user->monthly_savings) }}" min="0" step="0.01" required>
                        @error('monthly_savings')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Deducted from salary monthly</p>
                    </div>
                </div>
            </div>

            <!-- Member Status -->
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-user-check mr-2"></i> Member Status
                </h3>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="sacco_status" class="block text-sm font-medium text-gray-700">
                            SACCO Status
                        </label>
                        <select name="sacco_status" id="sacco_status" 
                                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('sacco_status') border-red-300 @enderror">
                            <option value="active" {{ old('sacco_status', $user->sacco_status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ old('sacco_status', $user->sacco_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ old('sacco_status', $user->sacco_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="inactive" {{ old('sacco_status', $user->sacco_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('sacco_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            SACCO Join Date
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {{ date('F j, Y', strtotime($user->sacco_join_date)) }}
                        </div>
                        <p class="text-xs text-gray-500">Join date cannot be changed</p>
                    </div>
                </div>
            </div>

            <!-- Read-only Information -->
            <div class="bg-gray-50 p-4 rounded-md">
                <h4 class="text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-info-circle mr-2"></i> Read-only Information
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900 ml-2">{{ date('M j, Y', strtotime($user->created_at)) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ date('M j, Y', strtotime($user->updated_at)) }}</span>
                    </div>
                    @if($user->memberApproval)
                    <div>
                        <span class="text-gray-500">Approval Status:</span>
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->memberApproval->status === 'approved') bg-green-100 text-green-800
                            @elseif($user->memberApproval->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($user->memberApproval->status) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-between">
                    <div>
                        <button type="button" onclick="confirmReset()"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-undo mr-2"></i> Reset Changes
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('secretary.members.show', $user) }}" 
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Reset Confirmation Modal -->
<div id="resetModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="reset-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="reset-modal-title">
                        Reset Changes
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to reset all changes? This will restore the form to its original values.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="resetForm()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Reset Form
                </button>
                <button type="button" onclick="closeResetModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmReset() {
        document.getElementById('resetModal').classList.remove('hidden');
    }
    
    function closeResetModal() {
        document.getElementById('resetModal').classList.add('hidden');
    }
    
    function resetForm() {
        // Reload the page to reset form
        window.location.reload();
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeResetModal();
        }
    });
    
    // Calculate loan eligibility when monthly savings changes
    document.getElementById('monthly_savings').addEventListener('input', function() {
        const monthlySavings = parseFloat(this.value) || 0;
        const loanEligibility = monthlySavings * 1.5;
        
        // Show eligibility information
        const eligibilityElement = document.getElementById('eligibilityInfo');
        if (!eligibilityElement) {
            const infoDiv = document.createElement('div');
            infoDiv.id = 'eligibilityInfo';
            infoDiv.className = 'mt-2 text-sm text-blue-600';
            infoDiv.innerHTML = `Estimated loan eligibility: KES <strong>${loanEligibility.toFixed(2)}</strong>`;
            this.parentNode.appendChild(infoDiv);
        } else {
            eligibilityElement.innerHTML = `Estimated loan eligibility: KES <strong>${loanEligibility.toFixed(2)}</strong>`;
        }
    });
</script>
@endpush