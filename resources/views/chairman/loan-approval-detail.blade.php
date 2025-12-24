@extends('components.dashboard-layout')

@section('title', 'Loan Approval - ' . $loan->user->name)

@section('content')
    <div class="space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('chairman.loan-approvals') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                ← Back to Approvals
            </a>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-2xl p-6 border border-indigo-200">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Review Loan Application</h1>
                    <p class="text-indigo-800 mt-2">Loan #{{ $loan->loan_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-indigo-900 font-semibold">Applied: {{ $loan->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Loan Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Member Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Member Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Full
                                    Name</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Employee
                                    Number</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->employee_number }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Department</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->department ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Employment Info -->
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Position</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->position ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Employment
                                    Type</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    {{ $loan->user->employment_type ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Member
                                    Since</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    {{ $loan->user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Next of Kin -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Email</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->email }}</p>
                        </div>
                        @if($loan->user->nextOfKin)
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Next of
                                    Kin</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->user->nextOfKin->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $loan->user->nextOfKin->phone_number }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Loan Details -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Loan Details</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Loan
                                Type</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ ucfirst($loan->loan_type) }}</p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Requested
                                Amount</label>
                            <p class="text-xl font-bold text-green-600 mt-1">KES {{ number_format($loan->amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Period
                                (Months)</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->period_months }}</p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Interest
                                Rate</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $loan->interest_rate }}%</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Interest
                                Amount</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                {{ number_format($loan->interest_amount, 2) }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Total
                                Repayable</label>
                            <p class="text-lg font-semibold text-gray-900 mt-1">KES
                                {{ number_format($loan->total_repayable, 2) }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-600">Monthly
                                Payment</label>
                            <p class="text-lg font-semibold text-blue-600 mt-1">KES
                                {{ number_format($loan->monthly_payment, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <label
                            class="block text-xs uppercase tracking-wider font-semibold text-gray-600 mb-2">Purpose</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ $loan->purpose ?? 'Not specified' }}</p>
                    </div>
                    
                    <!-- Supporting Document Section -->
                    @if($loan->support_document)
                        @php
                            $fileExt = strtolower(pathinfo($loan->support_document, PATHINFO_EXTENSION));
                            $fileName = basename($loan->support_document);
                            $filePath = asset('storage/' . $loan->support_document);
                            
                            // Determine file type and icon
                            $icon = 'fa-file';
                            $iconColor = 'text-blue-500';
                            $bgColor = 'bg-blue-50';
                            $previewable = in_array($fileExt, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                            
                            if ($fileExt === 'pdf') {
                                $icon = 'fa-file-pdf';
                                $iconColor = 'text-red-500';
                                $bgColor = 'bg-red-50';
                            } elseif (in_array($fileExt, ['doc', 'docx'])) {
                                $icon = 'fa-file-word';
                                $iconColor = 'text-blue-600';
                                $bgColor = 'bg-blue-50';
                            } elseif (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                                $icon = 'fa-file-image';
                                $iconColor = 'text-green-500';
                                $bgColor = 'bg-green-50';
                            }
                        @endphp
                        
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Supporting Document</h4>
                            
                            <div class="{{ $bgColor }} border rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-12 h-12 bg-white rounded-lg border mr-4">
                                            <i class="fas {{ $icon }} {{ $iconColor }} text-xl"></i>
                                        </div>
                                        
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                Loan Application Form
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $fileName }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        @if($previewable)
                                            <!-- Simple Preview Button -->
                                            <a href="javascript:void(0)" 
                                               onclick="openDocumentPreview('{{ $filePath }}', '{{ $fileExt }}')"
                                               class="preview-btn px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium flex items-center justify-center cursor-pointer">
                                                <i class="fas fa-eye mr-2"></i> Preview
                                            </a>
                                        @endif
                                        
                                        <a href="{{ $filePath }}" 
                                           download="{{ $fileName }}"
                                           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium flex items-center justify-center">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-xs text-gray-500">
                                @if($loan->application_type === 'assisted')
                                    <i class="fas fa-user-tie mr-1"></i> Assisted by Secretary: 
                                    {{ $loan->assistedBy->name ?? 'Unknown' }}
                                @else
                                    <i class="fas fa-user mr-1"></i> Self-applied by member
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Supporting Document</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="text-yellow-500 mr-3">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div>
                                        <p class="text-yellow-800 font-medium">No supporting document uploaded</p>
                                        <p class="text-yellow-700 text-sm mt-1">
                                            This loan application does not have a supporting document attached.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Member Account Status -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Account Status</h2>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-green-800">Savings
                                Balance</label>
                            <p class="text-2xl font-bold text-green-700 mt-1">KES
                                {{ number_format($loan->user->savings->available_savings ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-blue-800">Loan
                                Eligibility</label>
                            <p class="text-2xl font-bold text-blue-700 mt-1">KES
                                {{ number_format($loan->user->loan_eligibility ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-purple-800">Active
                                Loans</label>
                            <p class="text-2xl font-bold text-purple-700 mt-1">
                                {{ $loan->user->loans()->whereIn('status', ['active', 'disbursed'])->count() }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-sm text-amber-900">
                            <strong>Requested Amount vs Eligibility:</strong>
                            @if($loan->amount <= ($loan->user->loan_eligibility ?? 0))
                                <span class="text-green-700">✓ Member is eligible for requested amount</span>
                            @else
                                <span class="text-red-700">✗ Requested amount exceeds eligibility by KES
                                    {{ number_format($loan->amount - ($loan->user->loan_eligibility ?? 0), 2) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Approval Form -->
            <div class="lg:col-span-1">

                <!-- Approval Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900">Decision</h2>

                    @if($loan->status === 'pending')
                        <!-- Approve Form -->
                        <form action="{{ route('chairman.loans.approve', $loan->id) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm text-gray-700 font-medium mb-2">Additional Notes (Optional)</label>
                                <textarea name="notes"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    rows="3" placeholder="Add any notes for the member..."></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold transition">
                                ✓ Approve Loan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('chairman.loans.reject', $loan->id) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm text-gray-700 font-medium mb-2">Rejection Reason</label>
                                <textarea name="rejection_reason"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                    rows="3" placeholder="Explain why this loan is being rejected..." required></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition"
                                onclick="return confirm('Are you sure you want to reject this loan?');">
                                ✗ Reject Loan
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="font-medium text-gray-800">This loan has been {{ ucfirst($loan->status) }}.</p>
                            @if($loan->approver)
                                <p class="text-sm text-gray-600 mt-2">Approved/Processed by:
                                    <strong>{{ $loan->approver->name }}</strong> ({{ ucfirst($loan->approver->role) }})</p>
                            @endif
                            @if($loan->rejection_reason)
                                <p class="text-sm text-red-600 mt-2">Rejection reason: {{ $loan->rejection_reason }}</p>
                            @endif
                        </div>
                    @endif

                    <!-- Decision Info -->
                    <div class="mt-6 pt-6 border-t">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            <strong>Note:</strong> Once you approve or reject this loan, the member will be notified.
                            Approved loans will be marked for treasurer disbursement.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Simple Preview Modal -->
    <div id="documentPreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl">
            <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900" id="previewTitle">Document Preview</h3>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="downloadPreview()" 
                            class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-download"></i>
                    </button>
                    <button type="button" onclick="closePreview()" 
                            class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-4 overflow-auto max-h-[70vh]">
                <iframe id="previewIframe" class="w-full h-[500px] border-0 rounded-lg hidden"></iframe>
                <img id="previewImage" class="max-w-full h-auto mx-auto rounded-lg shadow-lg hidden" />
                <div id="unsupportedPreview" class="text-center p-8 hidden">
                    <i class="fas fa-file text-5xl text-gray-400 mb-4"></i>
                    <p class="text-gray-700 font-medium">Preview not available in browser</p>
                    <p class="text-sm text-gray-500 mt-2">Please download the file to view it.</p>
                    <button type="button" onclick="downloadPreview()" 
                            class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-download mr-2"></i>Download File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- INLINE JAVASCRIPT FOR TESTING -->
    <script>
        let currentPreviewFile = null;
        
        function openDocumentPreview(filePath, fileType) {
            console.log('Opening preview:', filePath, fileType);
            
            currentPreviewFile = filePath;
            
            const modal = document.getElementById('documentPreviewModal');
            const iframe = document.getElementById('previewIframe');
            const image = document.getElementById('previewImage');
            const unsupported = document.getElementById('unsupportedPreview');
            const title = document.getElementById('previewTitle');
            
            // Hide all
            iframe.classList.add('hidden');
            image.classList.add('hidden');
            unsupported.classList.add('hidden');
            
            // Set title
            const fileName = filePath.split('/').pop();
            title.textContent = 'Preview: ' + fileName;
            
            // Show appropriate preview
            if (fileType === 'pdf') {
                iframe.src = filePath;
                iframe.classList.remove('hidden');
            } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileType)) {
                image.src = filePath;
                image.alt = 'Preview: ' + fileName;
                image.classList.remove('hidden');
            } else {
                unsupported.classList.remove('hidden');
            }
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closePreview() {
            const modal = document.getElementById('documentPreviewModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('previewIframe').src = '';
        }
        
        function downloadPreview() {
            if (currentPreviewFile) {
                const a = document.createElement('a');
                a.href = currentPreviewFile;
                a.download = currentPreviewFile.split('/').pop();
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
        
        // Close with ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });
        
        // Close when clicking outside
        document.getElementById('documentPreviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreview();
            }
        });
        
        // Test that function exists
        console.log('Document preview functions loaded');
    </script>
@endsection