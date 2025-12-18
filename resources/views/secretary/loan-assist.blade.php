@extends('components.dashboard-layout')

@section('title', 'Loan Assistance')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Loan Application Assistance</h1>
                <p class="text-gray-500 mt-1">
                    Help members who need assistance with their loan applications
                </p>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
        <div class="flex items-start">
            <div class="text-2xl mr-4">📋</div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">How to Assist Members</h3>
                <ol class="list-decimal pl-5 text-gray-700 space-y-1">
                    <li>Select the member who needs assistance from the dropdown below</li>
                    <li>Fill in the loan application details on their behalf</li>
                    <li>Use the real-time calculator to ensure they qualify (1.5× savings rule)</li>
                    <li>Explain the terms (5% fixed interest) to the member</li>
                    <li>Submit the application which will go to Chairman for approval</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Simple Form Version (Like your working one) -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <form action="{{ route('secretary.loans.assisted') }}" method="POST" id="loanApplicationForm">
            @csrf
            
            <!-- Member Selection -->
            <div class="mb-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-user mr-2"></i> Select Member to Assist
                </h3>
                
                <div class="mb-4">
                    <label for="member_id" class="block text-sm font-medium text-gray-700">
                        Member *
                    </label>
                    <select name="member_id" id="member_id" 
                            class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent sm:text-sm rounded-lg @error('member_id') border-red-300 @enderror" required>
                        <option value="">Select a member</option>
                        @foreach($members as $member)
                            @php
                                $savings = $member->savings->available_savings ?? 0;
                                $maxLoan = $savings * 1.5;
                            @endphp
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}
                                    data-savings="{{ $savings }}"
                                    data-max-loan="{{ $maxLoan }}">
                                {{ $member->name }} ({{ $member->employee_number }}) - 
                                Savings: KES {{ number_format($savings, 2) }} | 
                                Max Loan: KES {{ number_format($maxLoan, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Selected Member Info -->
                <div id="memberInfo" class="bg-gray-50 p-4 rounded-lg {{ old('member_id') ? '' : 'hidden' }}">
                    <h4 class="font-medium text-gray-900 mb-2">Member Information</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Available Savings:</span>
                            <span id="availableSavings" class="ml-2 font-medium text-green-600">
                                {{ old('member_id') ? 'KES ' . number_format($members->firstWhere('id', old('member_id'))?->savings?->available_savings ?? 0, 2) : 'KES 0.00' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500">Maximum Loan Eligibility:</span>
                            <span id="loanEligibility" class="ml-2 font-medium text-blue-600">
                                @if(old('member_id'))
                                    @php
                                        $member = $members->firstWhere('id', old('member_id'));
                                        $savings = $member->savings->available_savings ?? 0;
                                        $maxLoan = $savings * 1.5;
                                    @endphp
                                    KES {{ number_format($maxLoan, 2) }}
                                @else
                                    KES 0.00
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Details -->
            <div class="mb-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">
                    <i class="fas fa-file-signature mr-2"></i> Loan Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                            Loan Amount (KES) *
                        </label>
                        <input type="number" name="amount" id="amount" 
                               class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('amount') border-red-300 @enderror" 
                               value="{{ old('amount') }}" min="1000" step="1000" required
                               oninput="calculateLoanPreview()">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">Minimum: KES 1,000</p>
                    </div>

                    <div>
                        <label for="period_months" class="block text-sm font-medium text-gray-700">
                            Repayment Period (Months) *
                        </label>
                        <select name="period_months" id="period_months" 
                                class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('period_months') border-red-300 @enderror" 
                                required
                                onchange="calculateLoanPreview()">
                            <option value="">Select period</option>
                            <option value="6" {{ old('period_months') == '6' ? 'selected' : '' }}>6 Months</option>
                            <option value="12" {{ old('period_months') == '12' ? 'selected' : '' }}>12 Months</option>
                            <option value="18" {{ old('period_months') == '18' ? 'selected' : '' }}>18 Months</option>
                            <option value="24" {{ old('period_months') == '24' ? 'selected' : '' }}>24 Months</option>
                            <option value="36" {{ old('period_months') == '36' ? 'selected' : '' }}>36 Months</option>
                            <option value="48" {{ old('period_months') == '48' ? 'selected' : '' }}>48 Months</option>
                            <option value="60" {{ old('period_months') == '60' ? 'selected' : '' }}>60 Months</option>
                        </select>
                        @error('period_months')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="loan_type" class="block text-sm font-medium text-gray-700">
                        Loan Type
                    </label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="loan_type_normal" name="loan_type" value="normal" 
                                   class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300" 
                                   {{ old('loan_type', 'normal') == 'normal' ? 'checked' : '' }}>
                            <label for="loan_type_normal" class="ml-3 block text-sm font-medium text-gray-700">
                                Normal Loan
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="loan_type_topup" name="loan_type" value="topup" 
                                   class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300" 
                                   {{ old('loan_type') == 'topup' ? 'checked' : '' }}>
                            <label for="loan_type_topup" class="ml-3 block text-sm font-medium text-gray-700">
                                Top-up Loan (Requires active loan with 50% paid)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="purpose" class="block text-sm font-medium text-gray-700">
                        Loan Purpose *
                    </label>
                    <textarea name="purpose" id="purpose" rows="3" 
                              class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('purpose') border-red-300 @enderror" 
                              placeholder="What will the loan be used for? (e.g., School fees, home renovation, medical expenses)" 
                              required>{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Calculation Preview -->
                <div id="loanPreview" class="mt-6 bg-gray-50 p-6 rounded-lg border border-gray-200 {{ (old('amount') && old('period_months')) ? '' : 'hidden' }}">
                    <h4 class="font-medium text-gray-900 mb-4 text-lg">Loan Preview</h4>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Principal Amount:</span>
                                <span id="previewPrincipal" class="font-medium">
                                    @if(old('amount'))
                                        KES {{ number_format(old('amount'), 2) }}
                                    @else
                                        KES 0.00
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Interest (5% per annum):</span>
                                <span id="previewInterest" class="font-medium text-blue-600">KES 0.00</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Repayable:</span>
                                <span id="previewTotal" class="font-medium text-green-600">KES 0.00</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-800 font-medium">Monthly Payment:</span>
                                <span id="previewMonthly" class="text-xl font-semibold text-gray-900">KES 0.00</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3" id="paymentDuration">For 0 months</p>
                </div>
            </div>

            <!-- Eligibility Warning -->
            <div id="eligibilityWarning" class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 hidden">
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">⚠️</span>
                    <span class="text-sm text-red-700" id="warningMessage"></span>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-yellow-500">📝</span>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Important Information</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Loans are issued at 1.5× the member's available savings</li>
                                <li>Interest rate is fixed at 5% per annum</li>
                                <li>For top-up loans, member must have paid at least 50% of current loan</li>
                                <li>All loans require chairman approval after submission</li>
                                <li>Member will be notified via email/SMS after approval</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <button type="reset" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-500"
                            onclick="resetForm()">
                        Clear Form
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center">
                        <span class="mr-2">📤</span>
                        Submit Loan Application
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Success Toast -->
@if(session('success'))
<div id="successToast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

<!-- Error Toast -->
@if(session('error'))
<div id="errorToast" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection

@push('scripts')
<script>
    // Show/hide member info when member is selected
    document.getElementById('member_id').addEventListener('change', function() {
        const memberId = this.value;
        const memberInfoDiv = document.getElementById('memberInfo');
        const selectedOption = this.options[this.selectedIndex];
        
        if (memberId) {
            const savings = parseFloat(selectedOption.getAttribute('data-savings')) || 0;
            const maxLoan = parseFloat(selectedOption.getAttribute('data-max-loan')) || 0;
            
            document.getElementById('availableSavings').textContent = 
                'KES ' + savings.toLocaleString('en-US', {minimumFractionDigits: 2});
            
            document.getElementById('loanEligibility').textContent = 
                'KES ' + maxLoan.toLocaleString('en-US', {minimumFractionDigits: 2});
            
            memberInfoDiv.classList.remove('hidden');
            
            // Validate loan amount if already entered
            validateLoanAmount();
        } else {
            memberInfoDiv.classList.add('hidden');
        }
    });
    
    // Calculate loan preview
    function calculateLoanPreview() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const period = parseInt(document.getElementById('period_months').value) || 0;
        const loanPreview = document.getElementById('loanPreview');
        
        if (amount > 0 && period > 0) {
            // Calculate 5% annual interest
            const interestRate = 0.05; // 5% per year
            const interestAmount = amount * interestRate * (period / 12);
            const totalRepayable = amount + interestAmount;
            const monthlyPayment = period > 0 ? totalRepayable / period : 0;
            
            // Update preview
            document.getElementById('previewPrincipal').textContent = 
                'KES ' + amount.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('previewInterest').textContent = 
                'KES ' + interestAmount.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('previewTotal').textContent = 
                'KES ' + totalRepayable.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('previewMonthly').textContent = 
                'KES ' + monthlyPayment.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('paymentDuration').textContent = 
                `For ${period} months (${(period/12).toFixed(1)} years)`;
            
            loanPreview.classList.remove('hidden');
            
            // Validate against eligibility
            validateLoanAmount();
        } else {
            loanPreview.classList.add('hidden');
        }
    }
    
    // Validate loan amount against eligibility
    function validateLoanAmount() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const memberSelect = document.getElementById('member_id');
        const selectedOption = memberSelect.options[memberSelect.selectedIndex];
        const warningDiv = document.getElementById('eligibilityWarning');
        const warningMessage = document.getElementById('warningMessage');
        
        if (selectedOption && selectedOption.value) {
            const maxEligible = parseFloat(selectedOption.getAttribute('data-max-loan')) || 0;
            
            if (amount > maxEligible) {
                warningMessage.textContent = 
                    `Loan amount exceeds maximum eligibility of KES ${maxEligible.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                warningDiv.classList.remove('hidden');
                
                // Add red border to amount input
                document.getElementById('amount').classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            } else {
                warningDiv.classList.add('hidden');
                document.getElementById('amount').classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            }
        }
    }
    
    // Reset form
    function resetForm() {
        document.getElementById('memberInfo').classList.add('hidden');
        document.getElementById('loanPreview').classList.add('hidden');
        document.getElementById('eligibilityWarning').classList.add('hidden');
        document.getElementById('amount').classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
    }
    
    // Auto-hide toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('#successToast, #errorToast');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 5000);
        });
        
        // Calculate preview if form has old values
        if (document.getElementById('amount').value && document.getElementById('period_months').value) {
            calculateLoanPreview();
        }
    });
    
    // Form validation on submit
    document.getElementById('loanApplicationForm').addEventListener('submit', function(e) {
        const memberId = document.getElementById('member_id').value;
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const period = document.getElementById('period_months').value;
        const purpose = document.getElementById('purpose').value.trim();
        
        // Basic validation
        if (!memberId) {
            e.preventDefault();
            alert('Please select a member');
            return false;
        }
        
        if (amount < 1000) {
            e.preventDefault();
            alert('Loan amount must be at least KES 1,000');
            return false;
        }
        
        if (!period) {
            e.preventDefault();
            alert('Please select a repayment period');
            return false;
        }
        
        if (!purpose) {
            e.preventDefault();
            alert('Please enter the loan purpose');
            return false;
        }
        
        // Eligibility validation
        const selectedOption = document.getElementById('member_id').options[document.getElementById('member_id').selectedIndex];
        if (selectedOption) {
            const maxEligible = parseFloat(selectedOption.getAttribute('data-max-loan')) || 0;
            if (amount > maxEligible) {
                e.preventDefault();
                alert('Loan amount exceeds maximum eligibility of KES ' + 
                      maxEligible.toLocaleString('en-US', {minimumFractionDigits: 2}));
                return false;
            }
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<span class="mr-2">⏳</span> Processing...';
            submitBtn.disabled = true;
        }
        
        return true;
    });
</script>
@endpush