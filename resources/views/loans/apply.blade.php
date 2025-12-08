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
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900">
                                    <option>School Fees</option>
                                    <option>Medical Bills</option>
                                    <option>House Construction</option>
                                    <option>Business Investment</option>
                                    <option>Vehicle Purchase</option>
                                    <option>Wedding Expenses</option>
                                    <option>Other (Specify)</option>
                                </select>
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
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900" rows="3"
                                placeholder="Any additional information about your loan request..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Submit -->
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center mr-3">4
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Submit Application</h2>
                    </div>

                    <div class="bg-gray-50 border-l-4 border-gray-300 p-4 mb-6 rounded">
                        <p class="text-gray-700 text-sm">
                            ✅ Your loan application will be reviewed by the Chairman and approved by the Committee. You will
                            be notified via email and SMS.
                        </p>
                    </div>

                    <div class="flex space-x-4">
                        <button
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-4 rounded-lg font-semibold text-lg transition">📝
                            Submit Loan Application</button>
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

            loanAmountSlider.addEventListener('input', syncLoanAmount);
            loanAmountInput.addEventListener('input', function () {
                let value = parseFloat(this.value);
                if (value < 10000) value = 10000;
                if (value > 225000) value = 225000;
                this.value = value;
                loanAmountSlider.value = value;
                loanAmountValue.textContent = formatCurrency(value);
                calculateLoan();
            });
            repaymentPeriodSlider.addEventListener('input', syncRepaymentPeriod);

            showEarlyPaymentBtn.addEventListener('click', function () {
                earlyPaymentCard.classList.toggle('hidden');
            });

            syncLoanAmount();
            syncRepaymentPeriod();

            // Top-up Loan Eligibility Check
            document.addEventListener('DOMContentLoaded', function () {
                const eligibilityIcon = document.getElementById('eligibilityIcon');
                const eligibilityText = document.getElementById('eligibilityText');
                const eligibilityDetail = document.getElementById('eligibilityDetail');
                const repaymentProgress = document.getElementById('repaymentProgress');
                const progressText = document.getElementById('progressText');
                const topupButton = document.getElementById('topupButton');
                const checkEligibilityBtn = document.getElementById('checkEligibility');

                // Mock data - In real app, this would come from API
                const userLoans = {
                    hasActiveLoan: true,
                    loanAmount: 150000,
                    amountRepaid: 42500,
                    amountRemaining: 107500,
                    repaymentPercentage: 28.3,
                    isEligibleForTopup: false
                };

                function checkTopupEligibility() {
                    // Check if user has active loan
                    if (!userLoans.hasActiveLoan) {
                        eligibilityIcon.textContent = '❌';
                        eligibilityIcon.className = 'text-red-500 mr-2';
                        eligibilityText.textContent = 'No Active Loan';
                        eligibilityDetail.textContent = 'You need an active loan to qualify for top-up';
                        repaymentProgress.style.width = '0%';
                        progressText.textContent = 'No active loan';
                        topupButton.classList.add('hidden');
                        return;
                    }

                    const percentage = userLoans.repaymentPercentage;
                    repaymentProgress.style.width = percentage + '%';
                    progressText.textContent = `${percentage}% repaid`;

                    // Check 50% rule
                    if (percentage >= 50) {
                        // ELIGIBLE
                        eligibilityIcon.textContent = '✅';
                        eligibilityIcon.className = 'text-green-500 mr-2';
                        eligibilityText.textContent = 'Eligible for Top-up';
                        eligibilityDetail.textContent = `You've repaid ${percentage}% of your current loan`;
                        topupButton.classList.remove('hidden');
                        topupButton.classList.add('bg-green-100', 'hover:bg-green-200', 'text-green-800');
                    } else {
                        // NOT ELIGIBLE YET
                        const needed = 50 - percentage;
                        const amountNeeded = (userLoans.loanAmount * 0.5) - userLoans.amountRepaid;

                        eligibilityIcon.textContent = '⚠️';
                        eligibilityIcon.className = 'text-yellow-500 mr-2';
                        eligibilityText.textContent = 'Not Eligible Yet';
                        eligibilityDetail.textContent = `Need ${needed.toFixed(1)}% more (KES ${amountNeeded.toLocaleString()})`;
                        topupButton.classList.add('hidden');
                    }
                }

                // Initial check
                checkTopupEligibility();

                // Manual check button
                checkEligibilityBtn.addEventListener('click', function () {
                    // Show loading
                    eligibilityIcon.textContent = '⏳';
                    eligibilityIcon.className = 'text-gray-500 mr-2';
                    eligibilityText.textContent = 'Checking...';
                    eligibilityDetail.textContent = 'Verifying your loan status';

                    // Simulate API call
                    setTimeout(() => {
                        checkTopupEligibility();
                        alert('Eligibility check complete!');
                    }, 1000);
                });

                // Add tooltip for top-up rules
                topupButton.addEventListener('mouseenter', function () {
                    this.setAttribute('title', 'Click to apply for additional loan. 5% fixed interest rate applies.');
                });
            });
        });
    </script>
@endsection