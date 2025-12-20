@extends('components.dashboard-layout')

@section('title', 'Member Details - ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $user->name }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fas fa-id-card mr-1.5"></i>
                            {{ $user->employee_number }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fas fa-envelope mr-1.5"></i>
                            {{ $user->email }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fas fa-phone mr-1.5"></i>
                            {{ $user->phone }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
            <a href="{{ route('secretary.members') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
            <a href="{{ route('secretary.members.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        @php
            $statusColors = [
                'active' => 'bg-green-100 text-green-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'rejected' => 'bg-red-100 text-red-800',
                'inactive' => 'bg-gray-100 text-gray-800'
            ];
            $color = $statusColors[$user->sacco_status] ?? 'bg-gray-100 text-gray-800';
        @endphp
        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $color }}">
            <i class="fas fa-circle mr-1.5" style="font-size: 0.5rem"></i>
            {{ ucfirst($user->sacco_status) }}
        </span>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    

@if(session('password_info'))
<div class="mb-6 rounded-md bg-blue-50 p-4 border border-blue-200">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-key text-blue-400"></i>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-medium text-blue-800 mb-2">
                <i class="fas fa-user-circle mr-1"></i> 
                New Credentials Generated for {{ session('password_info')['user'] }}
            </h3>
            
            <div class="bg-white p-3 rounded border border-blue-100 mt-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-600">Employee Number:</p>
                        <p class="font-mono font-medium text-gray-900">{{ session('password_info')['employee_number'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email:</p>
                        <p class="font-medium text-gray-900">{{ session('password_info')['email'] }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600">Temporary Password:</p>
                        <div class="flex items-center mt-1">
                            <code class="font-mono bg-gray-100 px-3 py-2 rounded text-lg font-bold text-gray-900 border border-gray-300 flex-1">
                                {{ session('password_info')['temporary_password'] }}
                            </code>
                            <button onclick="copyToClipboard('{{ session('password_info')['temporary_password'] }}')" 
                                    class="ml-2 px-3 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded text-sm font-medium">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-sm text-yellow-800">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    {{ session('password_info')['message'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        alert('Password copied to clipboard!');
    }, function(err) {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endif

    @if(session('error'))
        <div class="mb-6 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Personal & Employment Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-user-circle mr-2"></i> Personal Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Employee Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->employee_number }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">National ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->national_id }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ date('F j, Y', strtotime($user->date_of_birth)) }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Age</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($user->date_of_birth)->age }} years
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">SACCO Join Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ date('F j, Y', strtotime($user->sacco_join_date)) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Employment Information Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-briefcase mr-2"></i> Employment Information
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->department }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Position</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->position }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Employment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ date('F j, Y', strtotime($user->employment_date)) }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Years of Service</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($user->employment_date)->diffInYears() }} years
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Monthly Salary</dt>
                            <dd class="mt-1 text-sm text-gray-900">KES {{ number_format($user->monthly_salary, 2) }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Monthly Savings</dt>
                            <dd class="mt-1 text-sm text-gray-900">KES {{ number_format($user->monthly_savings, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Right Column: Savings, Next of Kin, Actions -->
        <div class="space-y-6">
            <!-- Savings Summary Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-piggy-bank mr-2"></i> Savings Summary
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if($user->savings)
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Savings</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600">
                                    KES {{ number_format($user->savings->total_savings, 2) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Available Balance</dt>
                                <dd class="mt-1 text-md text-gray-900">
                                    KES {{ number_format($user->savings->available_savings, 2) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Loan Eligibility</dt>
                                <dd class="mt-1 text-md text-blue-600">
                                    KES {{ number_format($user->savings->loan_eligibility, 2) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-500">
                                    {{ $user->savings->last_updated ? date('M j, Y', strtotime($user->savings->last_updated)) : 'Never' }}
                                </dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500">No savings record found</p>
                    @endif
                </div>
            </div>

            <!-- Next of Kin Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-users mr-2"></i> Next of Kin
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if($user->nextOfKin)
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->nextOfKin->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Relationship</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->nextOfKin->relationship }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->nextOfKin->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">National ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->nextOfKin->national_id ?? 'Not provided' }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500">No next of kin information</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <i class="fas fa-bolt mr-2"></i> Quick Actions
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6 space-y-3">
                   
                    <!-- Resend Credentials Button - New Addition -->
                    <form action="{{ route('secretary.members.resend-credentials', $user) }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <i class="fas fa-envelope mr-2"></i> Resend Credentials
                        </button>
                    </form>
                    
                    <a href="{{ route('secretary.loan-assist') }}?member_id={{ $user->id }}"
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-handshake mr-2"></i> Assist with Loan
                    </a>
                    
                    <a href="{{ route('reports.member-statements', $user->id) }}"
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-file-invoice mr-2"></i> View Statement
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Member Modal -->
<div id="rejectModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="reject-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form action="{{ route('secretary.members.reject', $user) }}" method="POST">
                @csrf
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-times text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="reject-modal-title">
                            Reject Member Registration
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-4">
                                Please provide a reason for rejecting {{ $user->name }}'s registration.
                            </p>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3"
                                      class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                      placeholder="Enter rejection reason..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject Member
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectModal();
        }
    });
</script>
@endpush