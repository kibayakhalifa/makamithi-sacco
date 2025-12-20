@extends('components.dashboard-layout')

@section('title', 'My Profile')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div class="flex items-center gap-4">
                    <!-- Profile Picture -->
                    <div class="relative">
                        @if($user->profile_picture && Storage::disk('public')->exists(str_replace('storage/', '', $user->profile_picture)))
                            <img src="{{ asset($user->profile_picture) }}" 
                                alt="Profile Picture" 
                                class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" 
                                alt="Profile Picture" 
                                class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                        @endif
                        <button onclick="document.getElementById('profilePictureModal').classList.remove('hidden')"
                                class="absolute bottom-0 right-0 bg-purple-600 text-white p-1.5 rounded-full hover:bg-purple-700 transition">
                            📷
                        </button>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                        <p class="text-purple-800 mt-2">Manage your personal and account information</p>
                    </div>
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

                <!-- Documents Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-lg font-bold text-gray-900">📁 Documents</h2>
                        <button onclick="document.getElementById('uploadDocumentModal').classList.remove('hidden')"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            📤 Upload New
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- National ID -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">National ID</p>
                                    <p class="text-xs text-gray-500">Required document</p>
                                </div>
                                @php
                                    $nationalIdDoc = $user->documents ? $user->documents->where('type', 'national_id')->first() : null;
                                @endphp
                                @if($nationalIdDoc)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">✓ Uploaded</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                @endif
                            </div>
                            @if($nationalIdDoc)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $nationalIdDoc->file_path) }}" target="_blank" 
                                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        📄 View Document
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded: {{ $nationalIdDoc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('national_id')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $nationalIdDoc ? 'Replace' : 'Upload' }}
                            </button>
                        </div>

                        <!-- Passport Photo -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Passport Photo</p>
                                    <p class="text-xs text-gray-500">Required document</p>
                                </div>
                                @php
                                    $passportPhotoDoc = $user->documents ? $user->documents->where('type', 'passport_photo')->first() : null;
                                @endphp
                                @if($passportPhotoDoc)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">✓ Uploaded</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                @endif
                            </div>
                            @if($passportPhotoDoc)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $passportPhotoDoc->file_path) }}" target="_blank"
                                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        📷 View Photo
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded: {{ $passportPhotoDoc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('passport_photo')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $passportPhotoDoc ? 'Replace' : 'Upload' }}
                            </button>
                        </div>

                        <!-- Employment Letter -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Employment Letter</p>
                                    <p class="text-xs text-gray-500">Required document</p>
                                </div>
                                @php
                                    $employmentLetterDoc = $user->documents ? $user->documents->where('type', 'employment_letter')->first() : null;
                                @endphp
                                @if($employmentLetterDoc)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">✓ Uploaded</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                @endif
                            </div>
                            @if($employmentLetterDoc)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $employmentLetterDoc->file_path) }}" target="_blank"
                                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        📄 View Document
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded: {{ $employmentLetterDoc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('employment_letter')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $employmentLetterDoc ? 'Replace' : 'Upload' }}
                            </button>
                        </div>

                        <!-- Bank Statement -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Bank Statement</p>
                                    <p class="text-xs text-gray-500">Optional document</p>
                                </div>
                                @php
                                    $bankStatementDoc = $user->documents ? $user->documents->where('type', 'bank_statement')->first() : null;
                                @endphp
                                @if($bankStatementDoc)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">✓ Uploaded</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">Optional</span>
                                @endif
                            </div>
                            @if($bankStatementDoc)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $bankStatementDoc->file_path) }}" target="_blank"
                                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        📄 View Document
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded: {{ $bankStatementDoc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('bank_statement')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $bankStatementDoc ? 'Replace' : 'Upload' }}
                            </button>
                        </div>

                        <!-- Pay Slip -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Pay Slip</p>
                                    <p class="text-xs text-gray-500">Optional document</p>
                                </div>
                                @php
                                    $paySlipDoc = $user->documents ? $user->documents->where('type', 'pay_slip')->first() : null;
                                @endphp
                                @if($paySlipDoc)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">✓ Uploaded</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">Optional</span>
                                @endif
                            </div>
                            @if($paySlipDoc)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $paySlipDoc->file_path) }}" target="_blank"
                                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        📄 View Document
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded: {{ $paySlipDoc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('pay_slip')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $paySlipDoc ? 'Replace' : 'Upload' }}
                            </button>
                        </div>

                        <!-- Other Documents -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">Other Documents</p>
                                    <p class="text-xs text-gray-500">Additional files</p>
                                </div>
                                @php
                                    $otherDocsCount = $user->documents ? $user->documents->whereNotIn('type', ['national_id', 'passport_photo', 'employment_letter', 'bank_statement', 'pay_slip'])->count() : 0;
                                    $otherDocs = $user->documents ? $user->documents->whereNotIn('type', ['national_id', 'passport_photo', 'employment_letter', 'bank_statement', 'pay_slip']) : collect([]);
                                @endphp
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                    {{ $otherDocsCount }}
                                </span>
                            </div>
                            @if($otherDocsCount > 0)
                                <div class="space-y-2 mt-2">
                                    @foreach($otherDocs->take(2) as $doc)
                                        <div class="flex items-center justify-between">
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                               class="text-sm text-blue-600 hover:text-blue-800 truncate">
                                                {{ $doc->name }}
                                            </a>
                                            <span class="text-xs text-gray-500">
                                                {{ $doc->created_at->format('d M') }}
                                            </span>
                                        </div>
                                    @endforeach
                                    @if($otherDocsCount > 2)
                                        <p class="text-xs text-gray-500">+{{ $otherDocsCount - 2 }} more</p>
                                    @endif
                                </div>
                            @endif
                            <button onclick="uploadSpecificDocument('other')"
                                class="mt-3 w-full text-sm text-center py-2 border border-gray-300 rounded hover:bg-gray-50 transition">
                                Add Document
                            </button>
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

                <!-- Document Status -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📋 Document Status</h3>
                    
                    <div class="space-y-3">
                        @php
                            $requiredDocs = ['national_id', 'passport_photo', 'employment_letter'];
                            $uploadedCount = 0;
                            if ($user->documents) {
                                foreach ($requiredDocs as $docType) {
                                    if ($user->documents->where('type', $docType)->first()) {
                                        $uploadedCount++;
                                    }
                                }
                            }
                            $percentage = count($requiredDocs) > 0 ? round(($uploadedCount / count($requiredDocs)) * 100) : 0;
                        @endphp
                        
                        <div class="mb-3">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Required Documents</span>
                                <span class="font-semibold">{{ $uploadedCount }}/{{ count($requiredDocs) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                @if($percentage == 100)
                                    ✅ All documents uploaded
                                @else
                                    {{ count($requiredDocs) - $uploadedCount }} document(s) remaining
                                @endif
                            </p>
                        </div>
                        
                        <div class="space-y-2">
                            @foreach($requiredDocs as $docType)
                                @php
                                    $docName = ucfirst(str_replace('_', ' ', $docType));
                                    $hasDoc = $user->documents ? $user->documents->where('type', $docType)->first() : null;
                                @endphp
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">{{ $docName }}</span>
                                    <span class="text-xs px-2 py-1 rounded {{ $hasDoc ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $hasDoc ? '✓ Uploaded' : 'Pending' }}
                                    </span>
                                </div>
                            @endforeach
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

    <!-- Profile Picture Upload Modal -->
    <div id="profilePictureModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-900">Update Profile Picture</h2>
                <p class="text-gray-600 text-sm mt-1">Upload a new profile photo (Max: 2MB)</p>
            </div>

            <form action="{{ route('member.profile.update-picture') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-400 transition">
                    <div id="imagePreview" class="mb-4">
                        @if($user->profile_picture && Storage::disk('public')->exists(str_replace('storage/', '', $user->profile_picture)))
                            <img src="{{ asset($user->profile_picture) }}" 
                                alt="Current Profile" 
                                class="w-32 h-32 rounded-full mx-auto object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto flex items-center justify-center">
                                <span class="text-4xl">👤</span>
                            </div>
                        @endif
                    </div>
                    
                    <input type="file" 
                           id="profilePictureInput" 
                           name="profile_picture" 
                           accept="image/*" 
                           class="hidden" 
                           onchange="previewImage(this)">
                    
                    <label for="profilePictureInput" class="cursor-pointer">
                        <div class="bg-purple-50 text-purple-700 px-4 py-2 rounded-lg font-medium hover:bg-purple-100 transition inline-block">
                            📁 Choose Image
                        </div>
                    </label>
                    <p class="text-xs text-gray-500 mt-2">JPG, PNG, or GIF • Max 2MB</p>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('profilePictureModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                        Upload Picture
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Document Upload Modal -->
    <div id="uploadDocumentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-900">Upload Document</h2>
                <p class="text-gray-600 text-sm mt-1">Upload a new document (Max: 5MB)</p>
            </div>

            <form action="{{ route('member.documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Document Type</label>
                    <select name="type" id="documentType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="national_id">National ID</option>
                        <option value="passport_photo">Passport Photo</option>
                        <option value="employment_letter">Employment Letter</option>
                        <option value="bank_statement">Bank Statement</option>
                        <option value="pay_slip">Pay Slip</option>
                        <option value="other">Other Document</option>
                    </select>
                </div>

                <div id="otherDocumentName" class="hidden">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Document Name</label>
                    <input type="text" name="name" placeholder="Enter document name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-400 transition">
                    <div class="text-4xl mb-4">📄</div>
                    <p class="text-gray-600 mb-4">Drag & drop your file here or</p>
                    
                    <input type="file" 
                           id="documentInput" 
                           name="document" 
                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" 
                           class="hidden" 
                           onchange="previewDocument(this)">
                    
                    <label for="documentInput" class="cursor-pointer">
                        <div class="bg-purple-50 text-purple-700 px-4 py-2 rounded-lg font-medium hover:bg-purple-100 transition inline-block">
                            📁 Choose File
                        </div>
                    </label>
                    <p class="text-xs text-gray-500 mt-2">PDF, JPG, PNG, DOC • Max 5MB</p>
                    
                    <div id="fileName" class="mt-4 text-sm text-gray-700 font-medium hidden"></div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('uploadDocumentModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">
                        Upload Document
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

        document.getElementById('profilePictureModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        document.getElementById('uploadDocumentModal').addEventListener('click', function (e) {
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

        // Image preview for profile picture
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = 
                        `<img src="${e.target.result}" alt="Preview" class="w-32 h-32 rounded-full mx-auto object-cover">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Document preview
        function previewDocument(input) {
            const fileNameElement = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                fileNameElement.textContent = `Selected file: ${fileName}`;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }

        // Show/hide document name field for "other" type
        document.getElementById('documentType').addEventListener('change', function() {
            const otherNameField = document.getElementById('otherDocumentName');
            if (this.value === 'other') {
                otherNameField.classList.remove('hidden');
            } else {
                otherNameField.classList.add('hidden');
            }
        });

        // Upload specific document
        function uploadSpecificDocument(type) {
            const modal = document.getElementById('uploadDocumentModal');
            const select = document.getElementById('documentType');
            
            // Set the document type
            select.value = type;
            
            // Show/hide name field
            const otherNameField = document.getElementById('otherDocumentName');
            if (type === 'other') {
                otherNameField.classList.remove('hidden');
            } else {
                otherNameField.classList.add('hidden');
            }
            
            // Show modal
            modal.classList.remove('hidden');
        }

        // Drag and drop for document upload
        const dropArea = document.querySelector('.border-dashed');
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-purple-500', 'bg-purple-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-purple-500', 'bg-purple-50');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = document.getElementById('documentInput');
                input.files = files;
                previewDocument(input);
            }
        }
    </script>
@endsection