@extends('components.dashboard-layout')

@section('title', 'Apply for Loan')

@section('content')
    <div class="space-y-6 font-sans">

        <!-- Banner -->
        <div class="bg-gray-50 rounded-2xl p-6 shadow-md flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Apply for a Loan</h1>
                <p class="text-gray-500 mt-2">Get up to 1.5× your savings at a fixed 5% interest rate</p>
            </div>
            <div class="text-center md:text-right mt-4 md:mt-0">
                <p class="text-gray-400 text-sm">Your Savings Balance</p>
                <p class="text-4xl font-bold text-gray-900">KES 150,000</p>
                <p class="text-gray-400 text-xs mt-1">Maximum loan: KES 225,000</p>
            </div>
        </div>

        <!-- Loan Application Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Loan Steps -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Step 1: Loan Details -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">1
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Loan Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Loan Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Loan Amount (KES)</label>
                            <input type="range" id="loanAmount" min="10000" max="225000" step="1000" value="150000"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <div class="flex justify-between text-sm text-gray-400 mt-2">
                                <span>KES 10,000</span>
                                <span id="loanAmountValue" class="font-bold text-gray-900">KES 150,000</span>
                                <span>KES 225,000</span>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Or enter specific
                                    amount:</label>
                                <input type="number" id="loanAmountInput"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-lg font-bold text-center"
                                    value="150000" min="10000" max="225000">
                            </div>
                        </div>

                        <!-- Repayment Period & Purpose -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Repayment Period (Months)</label>
                            <input type="range" id="repaymentPeriod" min="6" max="36" step="1" value="24"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <div class="flex justify-between text-sm text-gray-400 mt-2">
                                <span>6 months</span>
                                <span id="repaymentPeriodValue" class="font-bold text-gray-900">24 months</span>
                                <span>36 months</span>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Loan Purpose</label>
                                <select id="loanPurpose"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900">
                                    <option value="">Select Purpose</option>
                                    <option value="school_fees">School Fees</option>
                                    <option value="medical_bills">Medical Bills</option>
                                    <option value="house_construction">House Construction</option>
                                    <option value="business_investment">Business Investment</option>
                                    <option value="vehicle_purchase">Vehicle Purchase</option>
                                    <option value="wedding_expenses">Wedding Expenses</option>
                                    <option value="other">Other (Specify)</option>
                                </select>
                                <div id="otherPurposeContainer" class="mt-2 hidden">
                                    <input type="text" id="otherPurpose"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                        placeholder="Please specify loan purpose">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Step 2: Loan Calculation -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">2
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Loan Calculation</h2>
                    </div>

                    <div id="loanCalculation" class="space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                                <p class="text-sm text-gray-500">Principal Amount</p>
                                <p id="principalAmount" class="text-2xl font-bold text-gray-900">KES 150,000</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                                <p class="text-sm text-gray-500">Interest (5% Fixed)</p>
                                <p id="interestAmount" class="text-2xl font-bold text-gray-900">KES 7,500</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition">
                                <p class="text-sm text-gray-500">Total Repayable</p>
                                <p id="totalRepayable" class="text-2xl font-bold text-gray-900">KES 157,500</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-semibold text-gray-900">Monthly Repayment</p>
                                <p id="monthlyPayment" class="text-3xl font-bold text-gray-900">KES 6,562.50</p>
                            </div>
                            <p class="text-sm text-gray-500">For <span id="monthsText">24</span> months at 5% fixed interest
                            </p>
                        </div>

                        <div id="earlyPaymentCard" class="hidden bg-gray-100 p-4 rounded transition-all duration-300">
                            <h4 class="font-semibold text-gray-900 mb-2">💡 Early Payment Example</h4>
                            <p class="text-sm text-gray-700">New monthly payment: <span id="earlyPaymentExample"
                                    class="font-bold text-gray-900">KES 4,479.17</span></p>
                        </div>
                        <button id="showEarlyPayment" class="text-sm text-gray-600 hover:text-gray-900 transition">Show
                            early payment calculation</button>
                    </div>
                </div>

                <!-- Step 3: Personal Details -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">3
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Personal Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text" class="hidden" value="{{ auth()->user()->id }}" readonly>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900"
                                value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employee Number</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900"
                                value="{{ auth()->user()->employee_number ?? 'EMP001' }}" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900"
                                value="Finance Department" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Salary</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900"
                                value="KES 85,000" readonly>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                            <textarea id="additionalNotes"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900" rows="3"
                                placeholder="Any additional information about your loan request..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Support Document Upload -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">4
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Support Document Upload</h2>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                        <p class="text-blue-700 text-sm">
                            📄 <strong>Document Requirements:</strong> Please upload supporting documents for your loan
                            application.
                            This helps us process your application faster.
                        </p>
                    </div>

                    <!-- Document Upload Area -->
                    <div class="space-y-6">


                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Document</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="documentFile"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="documentFile" name="documentFile" type="file" class="sr-only"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, JPG, PNG up to 10MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="hidden">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p id="fileName" class="font-medium text-gray-900">document.pdf</p>
                                        <p id="fileSize" class="text-sm text-gray-500">2.5 MB</p>
                                    </div>
                                </div>
                                <button type="button" id="removeFile" class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Step 5: Submit Application -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">5
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Submit Application</h2>
                    </div>

                    <div class="bg-gray-50 border-l-4 border-gray-300 p-4 mb-6 rounded">
                        <p class="text-gray-700 text-sm">
                            ✅ Your loan application will be reviewed by the Chairman and approved by the Committee. You will
                            be notified via email and SMS.
                        </p>
                    </div>

                    <!-- Application Checklist -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded">
                        <p class="text-yellow-800 text-sm font-medium mb-2">Before submitting, please ensure:</p>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li class="flex items-center">
                                <input type="checkbox" id="check1" class="mr-2 h-4 w-4 text-blue-600 rounded">
                                <label for="check1">All loan details are correct</label>
                            </li>
                            <li class="flex items-center">
                                <input type="checkbox" id="check2" class="mr-2 h-4 w-4 text-blue-600 rounded">
                                <label for="check2">Support document is uploaded (if required)</label>
                            </li>
                            <li class="flex items-center">
                                <input type="checkbox" id="check3" class="mr-2 h-4 w-4 text-blue-600 rounded">
                                <label for="check3">I agree to the repayment terms</label>
                            </li>
                        </ul>
                    </div>

                    <div class="flex space-x-4">
                        <button id="submitApplication"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-4 rounded-lg font-semibold text-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                            📝 Submit Loan Application
                        </button>
                    </div>

                    <p class="text-sm text-gray-500 mt-4 text-center">By submitting, you agree to the SACCO loan terms and
                        conditions</p>
                </div>

            </div>

            <!-- Right Column: Loan Summary & Actions -->
            <div class="space-y-6">

                <!-- Loan Summary -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Loan Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600"><span>Loan Amount:</span><span id="summaryAmount"
                                class="font-bold text-gray-900">KES 150,000</span></div>
                        <div class="flex justify-between text-gray-600"><span>Interest Rate:</span><span
                                class="font-bold text-gray-900">5% Fixed</span></div>
                        <div class="flex justify-between text-gray-600"><span>Repayment Period:</span><span
                                id="summaryPeriod" class="font-bold text-gray-900">24 months</span></div>
                        <div class="flex justify-between text-gray-600"><span>Monthly Payment:</span><span
                                id="summaryMonthly" class="font-bold text-gray-900">KES 6,562.50</span></div>
                        <div class="flex justify-between text-gray-600"><span>Total Repayable:</span><span id="summaryTotal"
                                class="font-bold text-gray-900">KES 157,500</span></div>
                        <div class="border-t pt-3 mt-3 flex justify-between font-bold text-gray-900"><span>Interest
                                Cost:</span><span id="summaryInterest" class="text-gray-700">KES 7,500</span></div>
                    </div>

                    <!-- Document Status -->
                    <div id="documentStatus" class="mt-6 p-4 bg-yellow-50 rounded-lg flex items-center space-x-2 hidden">
                        <span class="text-yellow-600">📄</span>
                        <span class="font-semibold text-gray-900">Document Required</span>
                    </div>

                    <!-- Qualification Status -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg flex items-center space-x-2">
                        <span class="text-green-600">✅</span>
                        <span class="font-semibold text-gray-900">You Qualify!</span>
                    </div>
                </div>


                <!-- Top-up Loan Section -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🔄 Top-up Loan</h3>

                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Eligibility:</span> Members with existing loans who have repaid 50%
                            can get additional loans.
                        </p>
                    </div>

                    <!-- Eligibility Check -->
                    <div id="topupEligibility" class="space-y-3">
                        <!-- This will be updated by JavaScript -->
                        <div class="flex items-center">
                            <span id="eligibilityIcon" class="text-yellow-500 mr-2">⏳</span>
                            <div>
                                <p id="eligibilityText" class="font-medium text-gray-900">Checking eligibility...</p>
                                <p id="eligibilityDetail" class="text-sm text-gray-500">Loading your loan status</p>
                            </div>
                        </div>

                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div id="repaymentProgress" class="h-full bg-blue-500 rounded-full" style="width: 28.3%"></div>
                        </div>
                        <p id="progressText" class="text-xs text-gray-500 text-center">28.3% repaid</p>

                        <a href="{{ route('loans.top-up') }}" id="topupButton"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold transition flex items-center justify-center hidden">
                            🚀 Apply for Top-up
                        </a>

                        <button id="checkEligibility"
                            class="w-full bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-lg font-semibold transition">
                            🔍 Check Eligibility
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-3">
                        <button
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 py-3 rounded-lg font-semibold transition">📄
                            Download Loan Form</button>
                        <button
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 py-3 rounded-lg font-semibold transition">📧
                            Email Application</button>
                        <button
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 py-3 rounded-lg font-semibold transition">💰
                            Calculate Different Amount</button>
                        <a href="{{ route('savings.index') }}"
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-900 py-3 rounded-lg font-semibold flex justify-center">💎
                            Increase My Savings</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Existing loan calculation variables
            const loanAmountSlider = document.getElementById('loanAmount');
            const loanAmountInput = document.getElementById('loanAmountInput');
            const loanAmountValue = document.getElementById('loanAmountValue');
            const repaymentPeriodSlider = document.getElementById('repaymentPeriod');
            const repaymentPeriodValue = document.getElementById('repaymentPeriodValue');

            const principalAmount = document.getElementById('principalAmount');
            const interestAmount = document.getElementById('interestAmount');
            const totalRepayable = document.getElementById('totalRepayable');
            const monthlyPayment = document.getElementById('monthlyPayment');
            const monthsText = document.getElementById('monthsText');

            const summaryAmount = document.getElementById('summaryAmount');
            const summaryPeriod = document.getElementById('summaryPeriod');
            const summaryMonthly = document.getElementById('summaryMonthly');
            const summaryTotal = document.getElementById('summaryTotal');
            const summaryInterest = document.getElementById('summaryInterest');

            const earlyPaymentExample = document.getElementById('earlyPaymentExample');
            const earlyPaymentCard = document.getElementById('earlyPaymentCard');
            const showEarlyPaymentBtn = document.getElementById('showEarlyPayment');

            // New document upload variables
            const documentFileInput = document.getElementById('documentFile');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFileBtn = document.getElementById('removeFile');
            const documentTypeSelect = document.getElementById('documentType');
            const loanPurposeSelect = document.getElementById('loanPurpose');
            const otherPurposeContainer = document.getElementById('otherPurposeContainer');
            const documentStatus = document.getElementById('documentStatus');
            const submitApplicationBtn = document.getElementById('submitApplication');
            const check1 = document.getElementById('check1');
            const check2 = document.getElementById('check2');
            const check3 = document.getElementById('check3');

            const INTEREST_RATE = 0.05;

            function formatCurrency(amount) {
                return 'KES ' + amount.toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function calculateLoan() {
                let amount = parseFloat(loanAmountInput.value);
                let months = parseInt(repaymentPeriodSlider.value);

                const interest = amount * INTEREST_RATE;
                const total = amount + interest;
                const monthly = total / months;

                principalAmount.textContent = formatCurrency(amount);
                interestAmount.textContent = formatCurrency(interest);
                totalRepayable.textContent = formatCurrency(total);
                monthlyPayment.textContent = formatCurrency(monthly);
                monthsText.textContent = months;

                summaryAmount.textContent = formatCurrency(amount);
                summaryPeriod.textContent = `${months} months`;
                summaryMonthly.textContent = formatCurrency(monthly);
                summaryTotal.textContent = formatCurrency(total);
                summaryInterest.textContent = formatCurrency(interest);

                const earlyPayment = 50000;
                const newBalance = total - earlyPayment;
                const newMonthly = newBalance / months;
                earlyPaymentExample.textContent = formatCurrency(newMonthly);
            }

            function syncLoanAmount() {
                let value = loanAmountSlider.value;
                loanAmountInput.value = value;
                loanAmountValue.textContent = formatCurrency(parseFloat(value));
                calculateLoan();
            }

            function syncRepaymentPeriod() {
                let months = repaymentPeriodSlider.value;
                repaymentPeriodValue.textContent = `${months} months`;
                calculateLoan();
            }

            // File upload handling
            documentFileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (10MB max)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size exceeds 10MB limit. Please choose a smaller file.');
                        documentFileInput.value = '';
                        return;
                    }

                    // Validate file type
                    const validTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a valid file type (PDF, DOC, JPG, PNG).');
                        documentFileInput.value = '';
                        return;
                    }

                    // Show preview
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    filePreview.classList.remove('hidden');

                    // Update document status
                    documentStatus.classList.remove('hidden');
                    documentStatus.classList.remove('bg-yellow-50', 'text-yellow-600');
                    documentStatus.classList.add('bg-green-50', 'text-green-600');
                    documentStatus.querySelector('span:first-child').textContent = '✅';
                    documentStatus.querySelector('span:nth-child(2)').textContent = 'Document Uploaded';
                }
            });

            // Remove file
            removeFileBtn.addEventListener('click', function () {
                documentFileInput.value = '';
                filePreview.classList.add('hidden');
                documentStatus.classList.add('bg-yellow-50', 'text-yellow-600');
                documentStatus.classList.remove('bg-green-50', 'text-green-600');
                documentStatus.querySelector('span:first-child').textContent = '📄';
                documentStatus.querySelector('span:nth-child(2)').textContent = 'Document Required';
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Loan purpose change handler
            loanPurposeSelect.addEventListener('change', function () {
                if (this.value === 'other') {
                    otherPurposeContainer.classList.remove('hidden');
                } else {
                    otherPurposeContainer.classList.add('hidden');
                }

                // Show/hide document status based on loan amount
                const loanAmount = parseFloat(loanAmountInput.value);
                if (loanAmount > 50000) {
                    documentStatus.classList.remove('hidden');
                } else {
                    documentStatus.classList.add('hidden');
                }
            });

            // Update document status when loan amount changes
            loanAmountInput.addEventListener('input', function () {
                const loanAmount = parseFloat(this.value);
                if (loanAmount > 50000) {
                    documentStatus.classList.remove('hidden');
                } else {
                    documentStatus.classList.add('hidden');
                }
            });

            // Form validation before submission
            function validateForm() {
                const loanAmount = parseFloat(loanAmountInput.value);
                const loanPurpose = loanPurposeSelect.value;
                const hasDocument = !filePreview.classList.contains('hidden');
                const isDocumentTypeSelected = documentTypeSelect.value !== '';

                // Check if all checkboxes are checked
                const isChecklistComplete = check1.checked && check2.checked && check3.checked;

                // For loans above 50,000, document is required
                if (loanAmount > 50000 && !hasDocument) {
                    alert('Please upload a supporting document for loans above KES 50,000.');
                    return false;
                }

                if (!isChecklistComplete) {
                    alert('Please check all items in the checklist before submitting.');
                    return false;
                }

                if (!loanPurpose) {
                    alert('Please select a loan purpose.');
                    return false;
                }

                if (loanPurpose === 'other' && !document.getElementById('otherPurpose').value.trim()) {
                    alert('Please specify the loan purpose.');
                    return false;
                }

                return true;
            }

            // Submit application
            submitApplicationBtn.addEventListener('click', function (e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return;
                }

                // Prepare form data for submission
                const formData = new FormData();
                formData.append('loan_amount', loanAmountInput.value);
                formData.append('repayment_period', repaymentPeriodSlider.value);
                formData.append('loan_purpose', loanPurposeSelect.value);
                formData.append('additional_notes', document.getElementById('additionalNotes').value);
                formData.append('document_type', documentTypeSelect.value);
                formData.append('document_description', document.getElementById('documentDescription').value);

                if (loanPurposeSelect.value === 'other') {
                    formData.append('other_purpose', document.getElementById('otherPurpose').value);
                }

                if (documentFileInput.files[0]) {
                    formData.append('document_file', documentFileInput.files[0]);
                }

                // Here you would normally submit to your backend
                // For now, we'll just show a success message
                this.innerHTML = '⏳ Submitting...';
                this.disabled = true;

                setTimeout(() => {
                    alert('Application submitted successfully! You will receive a confirmation email shortly.');
                    this.innerHTML = '✅ Submitted Successfully';
                }, 2000);
            });

            // Drag and drop functionality
            const dropZone = document.querySelector('.border-dashed');
            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });

            dropZone.addEventListener('dragleave', function (e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });

            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
                documentFileInput.files = e.dataTransfer.files;
                documentFileInput.dispatchEvent(new Event('change'));
            });

            // Checklist validation for submit button
            function updateSubmitButton() {
                const isChecklistComplete = check1.checked && check2.checked && check3.checked;
                submitApplicationBtn.disabled = !isChecklistComplete;
            }

            [check1, check2, check3].forEach(checkbox => {
                checkbox.addEventListener('change', updateSubmitButton);
            });

            // Existing event listeners
            loanAmountSlider.addEventListener('input', syncLoanAmount);
            loanAmountInput.addEventListener('input', function () {
                let value = parseFloat(this.value);
                if (value < 10000) value = 10000;
                if (value > 225000) value = 225000;
                this.value = value;
                loanAmountSlider.value = value;
                loanAmountValue.textContent = formatCurrency(value);
                calculateLoan();
                updateSubmitButton(); // Update button when amount changes
            });
            repaymentPeriodSlider.addEventListener('input', syncRepaymentPeriod);

            showEarlyPaymentBtn.addEventListener('click', function () {
                earlyPaymentCard.classList.toggle('hidden');
            });

            syncLoanAmount();
            syncRepaymentPeriod();

            // Top-up Loan Eligibility Check (existing code remains)
            // ... [rest of existing top-up loan code]
        });
    </script>
@endsection