<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Member Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <livewire:profile.update-member-profile-form />
                </div>
            </div>

            <!-- Account Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Account Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Your account details and membership information.") }}
                        </p>
                    </header>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Employee Number</label>
                                <p class="mt-1 text-sm text-gray-900 font-semibold">{{ Auth::user()->employee_number }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">SACCO Status</label>
                                <p class="mt-1">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ Auth::user()->sacco_status === 'active' ? 'bg-green-100 text-green-800' : 
                                           (Auth::user()->sacco_status === 'inactive' ? 'bg-red-100 text-red-800' : 
                                           'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst(Auth::user()->sacco_status) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">SACCO Join Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->sacco_join_date?->format('F d, Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <p class="mt-1 text-sm text-gray-900 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if(Auth::user()->sacco_exit_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SACCO Exit Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->sacco_exit_date?->format('F d, Y') }}</p>
                            </div>
                            @endif

                            @if(Auth::user()->exit_reason)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Exit Reason</label>
                                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->exit_reason }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Account Created</label>
                                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->created_at?->format('F d, Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Profile Update</label>
                                <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->updated_at?->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('My Documents') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Your uploaded documents and certificates.") }}
                        </p>
                    </header>

                    <div class="mt-6">
                        <!-- Upload New Document -->
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Upload New Document</h3>
                            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Document Type</label>
                                        <select name="document_type" class="w-full text-sm border-gray-300 rounded-md">
                                            <option value="">Select type</option>
                                            <option value="national_id">National ID</option>
                                            <option value="passport">Passport</option>
                                            <option value="kra_pin">KRA PIN Certificate</option>
                                            <option value="pay_slip">Pay Slip</option>
                                            <option value="employment_letter">Employment Letter</option>
                                            <option value="bank_statement">Bank Statement</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Document Name</label>
                                        <input type="text" name="document_name" 
                                               class="w-full text-sm border-gray-300 rounded-md"
                                               placeholder="e.g., National ID Front">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">File</label>
                                        <input type="file" name="document_file" 
                                               class="w-full text-sm border-gray-300 rounded-md"
                                               accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                        Upload Document
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Documents List -->
                        <div class="overflow-hidden border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Document
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Upload Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- National ID Example -->
                                    @if(Auth::user()->national_id_image)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">National ID</div>
                                                    <div class="text-sm text-gray-500">national_id.jpg</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Identification
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ Auth::user()->updated_at?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Uploaded
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ Auth::user()->national_id_image_url }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ Auth::user()->national_id_image_url }}" download 
                                               class="text-green-600 hover:text-green-900">Download</a>
                                        </td>
                                    </tr>
                                    @endif

                                    <!-- Profile Photo Example -->
                                    @if(Auth::user()->profile_photo_path)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Profile Photo</div>
                                                    <div class="text-sm text-gray-500">profile_photo.jpg</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Photo
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ Auth::user()->updated_at?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Uploaded
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ Auth::user()->profile_photo_url }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ Auth::user()->profile_photo_url }}" download 
                                               class="text-green-600 hover:text-green-900">Download</a>
                                        </td>
                                    </tr>
                                    @endif

                                    <!-- Loan Documents Example -->
                                    @php
                                        $loanDocuments = Auth::user()->loans()->whereNotNull('support_document')->get();
                                    @endphp
                                    
                                    @foreach($loanDocuments as $loan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Loan Support Document</div>
                                                    <div class="text-sm text-gray-500">Loan #{{ $loan->loan_number }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Loan Document
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $loan->created_at?->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ Storage::url($loan->support_document) }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                            <a href="{{ Storage::url($loan->support_document) }}" download 
                                               class="text-green-600 hover:text-green-900">Download</a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- No Documents Message -->
                                    @if(!Auth::user()->national_id_image && !Auth::user()->profile_photo_path && $loanDocuments->isEmpty())
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No documents uploaded</h3>
                                            <p class="mt-1 text-sm text-gray-500">Upload your documents to complete your profile.</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Financial Summary') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Your current financial status with the SACCO.") }}
                        </p>
                    </header>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-blue-900">Total Savings</h3>
                                    <p class="text-xl font-bold text-blue-600 mt-1">
                                        KES {{ number_format(Auth::user()->total_savings ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-green-900">Loan Eligibility</h3>
                                    <p class="text-xl font-bold text-green-600 mt-1">
                                        KES {{ number_format(Auth::user()->loan_eligibility ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-purple-900">Active Loans</h3>
                                    <p class="text-xl font-bold text-purple-600 mt-1">
                                        {{ Auth::user()->active_loans_count ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Change Password -->
                    <div>
                        <livewire:profile.update-password-form />
                    </div>

                    <!-- Delete Account -->
                    <div>
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>