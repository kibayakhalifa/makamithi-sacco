@extends('components.dashboard-layout')

@section('title', 'Apply for Loan')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Apply for a Loan</h1>
                    <p class="text-blue-800 text-sm mt-1">Get quick access to funds based on your savings</p>
                </div>
                <div class="space-y-2">
                    <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                        <p class="text-gray-600 text-xs">You can borrow now</p>
                        <p class="text-2xl font-bold text-green-600">KES {{ number_format($available_eligibility, 0) }}</p>
                        <p class="text-xs text-gray-500 mt-1">of KES {{ number_format($total_eligibility, 0) }} total eligibility</p>
                    </div>
                </div>
            </div>
        </div>

        @if($hasActiveFirstLoan)
            <!-- Active Loan Status -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full {{ $isEligibleForSecondLoan ? 'bg-green-100' : 'bg-yellow-100' }} flex items-center justify-center">
                            <span class="{{ $isEligibleForSecondLoan ? 'text-green-600' : 'text-yellow-600' }}">📋</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Your Current Loan</h3>
                        <p class="text-sm text-gray-600">
                            @if($isEligibleForSecondLoan)
                                ✅ Eligible for a Second Loan
                            @else
                                ⏳ Pay 50% to qualify for Second Loan
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($firstLoan)
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $firstLoan->loan_number }}</p>
                                <p class="text-xs text-gray-600">Balance: KES {{ number_format($firstLoan->remaining_balance, 0) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold {{ $isEligibleForSecondLoan ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ number_format($firstLoan->percentage_paid, 1) }}% Paid
                                </p>
                                @if(!$isEligibleForSecondLoan)
                                    <p class="text-xs text-red-600">{{ max(0, 50 - $firstLoan->percentage_paid) }}% to go</p>
                                @endif
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="{{ $isEligibleForSecondLoan ? 'bg-green-600' : 'bg-yellow-600' }} h-1.5 rounded-full" 
                                  style="width: {{ min($firstLoan->percentage_paid, 100) }}%"></div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Loan Type Selection -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 class="font-bold text-gray-900 mb-3">1. Select Loan Type</h2>

                    <div class="space-y-2">
                        <!-- First Loan -->
                        @if(!$hasActiveFirstLoan)
                            <label class="flex items-center p-3 border border-blue-300 rounded-lg cursor-pointer hover:bg-blue-50 transition bg-blue-50">
                                <input type="radio" name="loan_type" value="first" checked class="w-4 h-4 text-blue-600">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-900">First Loan</p>
                                    <p class="text-xs text-gray-600">Apply for your initial loan</p>
                                </div>
                            </label>
                        @else
                            <!-- First Loan Disabled -->
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50 opacity-60">
                                <input type="radio" name="loan_type" value="first" disabled class="w-4 h-4 text-gray-400">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-600">First Loan</p>
                                    <p class="text-xs text-gray-500">Already taken</p>
                                </div>
                            </div>
                        @endif

                        <!-- Second Loan -->
                        @if($hasActiveFirstLoan && $isEligibleForSecondLoan)
                            <label class="flex items-center p-3 border border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="loan_type" value="second" checked class="w-4 h-4 text-green-600">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-900">Second Loan ✓</p>
                                    <p class="text-xs text-gray-600">Apply for an additional new loan</p>
                                    <p class="text-xs text-green-600 mt-1">Eligible - {{ number_format($firstLoan->percentage_paid, 1) }}% repaid</p>
                                </div>
                            </label>
                        @elseif($hasActiveFirstLoan && !$isEligibleForSecondLoan)
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50 opacity-60">
                                <input type="radio" name="loan_type" value="second" disabled class="w-4 h-4 text-gray-400">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-600">Second Loan</p>
                                    <p class="text-xs text-gray-500">Requires 50% repayment of first loan</p>
                                    <p class="text-xs text-red-600 mt-1">{{ number_format($firstLoan->percentage_paid ?? 0, 1) }}% repaid - Need 50%</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if((!$hasActiveFirstLoan) || ($hasActiveFirstLoan && $isEligibleForSecondLoan))
                <!-- Loan Details Form -->
                <form action="{{ route('member.loans.store') }}" method="POST" enctype="multipart/form-data" 
                      id="loanForm" class="space-y-5">
                    @csrf

                    <input type="hidden" name="loan_type" id="selectedLoanType" value="{{ !$hasActiveFirstLoan ? 'first' : 'second' }}">

                    <!-- Loan Details -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h2 class="font-bold text-gray-900 mb-3">2. Loan Details</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Loan Amount (KES)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500 text-sm">KES</span>
                                    <input type="number" name="amount" id="loanAmount" required 
                                        min="5000" 
                                        max="{{ $available_eligibility }}" 
                                        step="1000"
                                        value="{{ old('amount') }}"
                                        class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="50,000"
                                        oninput="updateRepaymentSchedule()">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Max: KES {{ number_format($available_eligibility, 2) }}
                                </p>
                                @error('amount')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Repayment Period (Months)</label>
                                    <div class="relative">
                                        <input type="number" name="period_months" id="periodMonths" required 
                                            min="6" max="60" step="1"
                                            value="{{ old('period_months', 12) }}"
                                            class="w-full pl-3 pr-8 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="12"
                                            oninput="updateRepaymentSchedule()">
                                        <span class="absolute right-3 top-3 text-gray-500 text-sm">months</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">6 - 60 months</p>
                                    @error('period_months')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Purpose</label>
                                    <input type="text" name="purpose" required 
                                        value="{{ old('purpose') }}"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="e.g., Home improvement, Education">
                                    @error('purpose')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Improved File Upload Section -->
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Loan Application Form</label>
                                
                                <!-- File Input -->
                                <input type="file" name="support_document" id="supportDocument" 
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="hidden"
                                       onchange="handleFileUpload(event)">
                                
                                <!-- Upload Area -->
                                <div id="uploadContainer">
                                    <label for="supportDocument" 
                                           class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-400 transition-all duration-200"
                                           id="uploadArea">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" id="uploadContent">
                                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="mb-1 text-sm text-gray-500">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">PDF, JPG or PNG (MAX. 5MB)</p>
                                        </div>
                                    </label>
                                    
                                    <!-- Uploaded File Preview -->
                                    <div id="filePreview" class="hidden mt-3">
                                        <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p id="fileName" class="text-sm font-medium text-gray-900">document.pdf</p>
                                                    <p id="fileSize" class="text-xs text-gray-500">2.4 MB</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button type="button" onclick="previewFile()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View
                                                </button>
                                                <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                                <span>Upload progress</span>
                                                <span id="progressText">100%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                <div id="progressBar" class="bg-green-600 h-1.5 rounded-full" style="width: 100%"></div>
                                            </div>
                                            <p class="text-xs text-green-600 mt-1 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Upload complete
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('support_document')
                                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Repayment Preview -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h2 class="font-bold text-gray-900 mb-3">3. Repayment Summary</h2>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                            <div class="p-2 border border-gray-200 rounded bg-gray-50">
                                <p class="text-xs text-gray-600">Loan Amount</p>
                                <p class="font-bold text-gray-900 text-sm" id="previewAmount">KES 0</p>
                            </div>
                            <div class="p-2 border border-gray-200 rounded bg-gray-50">
                                <p class="text-xs text-gray-600">Interest Rate</p>
                                <p class="font-bold text-gray-900 text-sm">5.0%</p>
                            </div>
                            <div class="p-2 border border-gray-200 rounded bg-gray-50">
                                <p class="text-xs text-gray-600">Period</p>
                                <p class="font-bold text-gray-900 text-sm" id="previewPeriod">0 months</p>
                            </div>
                            <div class="p-2 border border-gray-200 rounded bg-gray-50">
                                <p class="text-xs text-gray-600">Total Repayable</p>
                                <p class="font-bold text-gray-900 text-sm" id="previewTotal">KES 0</p>
                            </div>
                        </div>
                        
                        <div class="p-3 border border-blue-200 rounded-lg bg-blue-50">
                            <p class="text-sm font-medium text-blue-900">Monthly Payment</p>
                            <p class="text-xl font-bold text-blue-600" id="previewMonthly">KES 0</p>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <h2 class="font-bold text-gray-900 mb-3">4. Terms & Conditions</h2>

                        <div class="space-y-2 mb-3 text-sm text-gray-600">
                            <p>✓ I confirm that the information provided is accurate and complete</p>
                            <p>✓ I understand the loan will be disbursed to my designated account</p>
                            <p>✓ I agree to repay the loan with interest as per the agreed schedule</p>
                        </div>

                        <label class="flex items-center">
                            <input type="checkbox" name="agree_terms" required class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-2 text-sm text-gray-700">I agree to the above terms and conditions</span>
                        </label>
                        @error('agree_terms')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3">
                        <a href="{{ route('member.dashboard') }}"
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition text-sm">
                            Submit Application
                        </button>
                    </div>
                </form>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-5">

                <!-- Eligibility Breakdown -->
                <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-bold text-gray-900 mb-3">📊 Your Borrowing Capacity</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                            <span class="text-gray-600">Total Eligibility</span>
                            <span class="font-bold text-blue-900">KES {{ number_format($total_eligibility, 0) }}</span>
                        </div>
                        <div class="text-center text-gray-500 text-xs">–</div>
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                            <span class="text-gray-600">Current Loans</span>
                            <span class="font-bold text-amber-900">KES {{ number_format($current_loan_balance, 0) }}</span>
                        </div>
                        <div class="border-t border-gray-300 pt-3"></div>
                        <div class="flex justify-between items-center p-3 bg-green-100 rounded-lg">
                            <span class="text-gray-700 font-semibold">Available Now</span>
                            <span class="font-bold text-green-700 text-lg">KES {{ number_format($available_eligibility, 0) }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-600 mt-3 p-2 bg-white rounded border border-gray-200">
                        ✓ Your available funds = (Savings × 1.5) − Current loan balance
                    </p>
                </div>

                <!-- Calculator -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-bold text-gray-900 mb-3">💡 Repayment Calculator</h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="text-gray-600 text-xs">Loan Amount</label>
                            <p class="text-lg font-bold text-blue-600" id="calcAmount">KES 0</p>
                        </div>
                        <div class="border-t pt-3">
                            <label class="text-gray-600 text-xs">Repayment Period</label>
                            <p class="font-semibold text-gray-900" id="calcPeriod">- months</p>
                        </div>
                        <div class="border-t pt-3">
                            <label class="text-gray-600 text-xs">Interest Rate</label>
                            <p class="font-semibold text-gray-900">5% p.a.</p>
                        </div>
                        <div class="border-t pt-3 bg-blue-50 rounded p-2">
                            <label class="text-gray-600 text-xs uppercase">Monthly Payment</label>
                            <p class="text-lg font-bold text-blue-600" id="monthlyPayment">KES 0</p>
                        </div>
                    </div>
                </div>

                <!-- Loan Rules -->
                <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-5">
                    <h3 class="font-bold text-gray-900 mb-2">📋 Loan Rules</h3>
                    <ul class="text-sm text-gray-700 space-y-1.5">
                        <li class="flex items-start gap-1.5">
                            <span class="text-yellow-600 mt-0.5">•</span>
                            <span><strong>First Loan:</strong> Based on your savings</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-yellow-600 mt-0.5">•</span>
                            <span><strong>Second Loan:</strong> Requires 50% repayment of first loan</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-yellow-600 mt-0.5">•</span>
                            <span><strong>Max amount:</strong> 1.5× your total savings</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-yellow-600 mt-0.5">•</span>
                            <span><strong>Minimum:</strong> KES 5,000</span>
                        </li>
                    </ul>
                </div>

                <!-- Process -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-bold text-gray-900 mb-3">⚡ Quick Process</h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">
                                1</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Apply Online</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">
                                2</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Committee Review</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">
                                3</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Get Approved</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-bold">
                                4</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Receive Funds</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        // Update loan type selection
        document.addEventListener('DOMContentLoaded', function() {
            const loanTypeRadios = document.querySelectorAll('input[name="loan_type"]');
            const loanTypeHidden = document.getElementById('selectedLoanType');
            
            loanTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    loanTypeHidden.value = this.value;
                });
            });
        });

        // Calculator functionality
        const loanAmountInput = document.getElementById('loanAmount');
        const periodInput = document.getElementById('periodMonths');
        const calcAmount = document.getElementById('calcAmount');
        const calcPeriod = document.getElementById('calcPeriod');
        const monthlyPayment = document.getElementById('monthlyPayment');
        const previewAmount = document.getElementById('previewAmount');
        const previewPeriod = document.getElementById('previewPeriod');
        const previewTotal = document.getElementById('previewTotal');
        const previewMonthly = document.getElementById('previewMonthly');

        const interestRate = 0.05; // 5% per annum

        function calculateMonthlyPayment(amount, months) {
            if (amount <= 0 || months <= 0) return 0;
            
            const monthlyRate = interestRate / 12;
            const monthlyPaymentAmount = (amount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));
            
            return monthlyPaymentAmount;
        }

        function calculateTotalRepayable(amount, months) {
            const monthlyPayment = calculateMonthlyPayment(amount, months);
            return monthlyPayment * months;
        }

        function updateRepaymentSchedule() {
            const amount = parseFloat(loanAmountInput.value) || 0;
            const months = parseInt(periodInput.value) || 0;

            calcAmount.textContent = 'KES ' + amount.toLocaleString('en-US', { maximumFractionDigits: 0 });
            calcPeriod.textContent = months + ' months';
            
            previewAmount.textContent = 'KES ' + amount.toLocaleString('en-US', { maximumFractionDigits: 0 });
            previewPeriod.textContent = months + ' months';

            if (amount > 0 && months > 0) {
                const monthlyPaymentAmount = calculateMonthlyPayment(amount, months);
                const totalRepayable = calculateTotalRepayable(amount, months);
                
                const formattedMonthly = monthlyPaymentAmount.toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
                
                monthlyPayment.textContent = 'KES ' + formattedMonthly;
                previewMonthly.textContent = 'KES ' + formattedMonthly;
                previewTotal.textContent = 'KES ' + totalRepayable.toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
            } else {
                monthlyPayment.textContent = 'KES 0';
                previewMonthly.textContent = 'KES 0';
                previewTotal.textContent = 'KES 0';
            }
        }

        // Event listeners for calculator
        if (loanAmountInput) {
            loanAmountInput.addEventListener('input', updateRepaymentSchedule);
            loanAmountInput.addEventListener('change', function() {
                this.value = Math.max(5000, Math.min(this.value, this.max));
                updateRepaymentSchedule();
            });
        }
        
        if (periodInput) {
            periodInput.addEventListener('input', updateRepaymentSchedule);
            periodInput.addEventListener('change', function() {
                this.value = Math.max(6, Math.min(this.value, 60));
                updateRepaymentSchedule();
            });
        }

        // File Upload Functionality
        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file type
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a PDF, JPG, or PNG file.');
                event.target.value = '';
                return;
            }

            // Validate file size (5MB max)
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if (file.size > maxSize) {
                alert('File size must be less than 5MB.');
                event.target.value = '';
                return;
            }

            // Show upload progress
            simulateUploadProgress(file);
        }

        function simulateUploadProgress(file) {
            const uploadArea = document.getElementById('uploadArea');
            const uploadContent = document.getElementById('uploadContent');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            // Update file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            // Hide upload area, show preview
            uploadArea.style.display = 'none';
            filePreview.classList.remove('hidden');

            // Simulate upload progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                progressBar.style.width = progress + '%';
                progressText.textContent = progress + '%';

                if (progress >= 100) {
                    clearInterval(interval);
                    progressText.textContent = '100%';
                    progressBar.classList.remove('bg-green-600');
                    progressBar.classList.add('bg-green-500');
                    
                    // Show success message
                    setTimeout(() => {
                        const successMsg = document.createElement('p');
                        successMsg.className = 'text-xs text-green-600 mt-2 flex items-center';
                        successMsg.innerHTML = `
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Upload complete
                        `;
                        progressBar.parentElement.parentElement.appendChild(successMsg);
                    }, 300);
                }
            }, 50);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function previewFile() {
            const fileInput = document.getElementById('supportDocument');
            const file = fileInput.files[0];
            
            if (file) {
                if (file.type === 'application/pdf') {
                    // For PDFs, open in new tab (if converted to data URL)
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const pdfWindow = window.open();
                        pdfWindow.document.write(`
                            <html>
                                <head>
                                    <title>${file.name}</title>
                                </head>
                                <body style="margin: 0; padding: 0;">
                                    <embed src="${e.target.result}" type="application/pdf" width="100%" height="100%">
                                </body>
                            </html>
                        `);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('image/')) {
                    // For images, open in new tab
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgWindow = window.open();
                        imgWindow.document.write(`
                            <html>
                                <head>
                                    <title>${file.name}</title>
                                    <style>
                                        body { margin: 0; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f5f5f5; }
                                        img { max-width: 100%; max-height: 90vh; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                                    </style>
                                </head>
                                <body>
                                    <img src="${e.target.result}" alt="${file.name}">
                                </body>
                            </html>
                        `);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function removeFile() {
            const fileInput = document.getElementById('supportDocument');
            const uploadArea = document.getElementById('uploadArea');
            const filePreview = document.getElementById('filePreview');
            
            // Reset file input
            fileInput.value = '';
            
            // Show upload area, hide preview
            uploadArea.style.display = 'flex';
            filePreview.classList.add('hidden');
            
            // Clear any success messages
            const successMsgs = filePreview.querySelectorAll('.text-green-600');
            successMsgs.forEach(msg => msg.remove());
        }

        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');
        if (uploadArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadArea.classList.add('bg-blue-50', 'border-blue-400');
            }

            function unhighlight() {
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400');
            }

            uploadArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    document.getElementById('supportDocument').files = files;
                    const event = new Event('change', { bubbles: true });
                    document.getElementById('supportDocument').dispatchEvent(event);
                }
            }
        }

        // Form validation
        const loanForm = document.getElementById('loanForm');
        if (loanForm) {
            loanForm.addEventListener('submit', function(e) {
                const amount = parseFloat(loanAmountInput.value) || 0;
                const months = parseInt(periodInput.value) || 0;
                const fileInput = document.getElementById('supportDocument');
                
                if (amount < 5000 || amount > loanAmountInput.max) {
                    e.preventDefault();
                    alert('Loan amount must be between KES 5,000 and KES ' + 
                          Number(loanAmountInput.max).toLocaleString('en-US') + '.');
                    loanAmountInput.focus();
                    return;
                }
                
                if (months < 6 || months > 60) {
                    e.preventDefault();
                    alert('Repayment period must be between 6 and 60 months.');
                    periodInput.focus();
                    return;
                }
                
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please upload a loan application form.');
                    uploadArea.click();
                    return;
                }
                
                if (!document.querySelector('input[name="agree_terms"]:checked')) {
                    e.preventDefault();
                    alert('You must agree to the terms and conditions.');
                    return;
                }
            });
        }

        // Initialize calculator on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (loanAmountInput && loanAmountInput.value) {
                loanAmountInput.value = Math.max(5000, Math.min(loanAmountInput.value, loanAmountInput.max));
            }
            
            if (periodInput && periodInput.value) {
                periodInput.value = Math.max(6, Math.min(periodInput.value, 60));
            }
            
            updateRepaymentSchedule();
        });
    </script>
@endsection