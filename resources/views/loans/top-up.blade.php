@extends('components.dashboard-layout')

@section('title', 'Top-up Loan')

@section('content')
    <div class="space-y-6 font-sans">

        <!-- Check eligibility first -->
        @php
            // SIMPLE MOCK DATA - in real app, this comes from database
            $hasActiveLoan = true; // Does user have a loan?
            $loanAmount = 150000; // Loan amount
            $amountRepaid = 75000; // How much paid back
            $repaymentPercentage = ($amountRepaid / $loanAmount) * 100; // Calculate %
            $isEligible = $repaymentPercentage >= 50; // 50% rule
            $amountNeeded = ($loanAmount * 0.5) - $amountRepaid; // How much more needed
        @endphp

        <!-- Header Banner -->
        <div class="bg-gray-50 rounded-2xl p-6 shadow-md flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Top-up Loan Facility</h1>
                <p class="text-gray-500 mt-2">Get additional loans after repaying 50% of your current loan</p>
            </div>
            <div class="text-center md:text-right mt-4 md:mt-0">
                <p class="text-gray-400 text-sm">Current Savings</p>
                <p class="text-4xl font-bold text-gray-900">KES 150,000</p>
            </div>
        </div>

        <!-- =========================================== -->
        <!-- CHECK 1: DOES USER HAVE ACTIVE LOAN? -->
        <!-- =========================================== -->
        @if(!$hasActiveLoan)
            <!-- USER HAS NO LOAN AT ALL -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <div class="flex items-center">
                    <span class="text-red-500 mr-3 text-2xl">❌</span>
                    <div>
                        <h3 class="text-lg font-semibold text-red-900">No Active Loan Found</h3>
                        <p class="text-red-700 mt-1">
                            You need an active loan to qualify for top-up facility.
                            <a href="{{ route('member.loans.apply') }}" class="font-semibold underline hover:text-red-800">
                                Apply for a loan first
                            </a>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- =========================================== -->
            <!-- CHECK 2: HAS USER REPAID 50%? -->
            <!-- =========================================== -->
        @elseif(!$isEligible)
            <!-- USER HAS LOAN BUT NOT REPAID 50% -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-center">
                    <span class="text-yellow-500 mr-3 text-2xl">⚠️</span>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-900">Not Eligible Yet</h3>
                        <p class="text-yellow-700 mt-1">
                            You need to repay <strong>50%</strong> of your current loan to qualify for top-up.
                        </p>
                        <div class="mt-4">
                            <!-- Progress bar -->
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Repayment Progress</span>
                                <span>{{ number_format($repaymentPercentage, 1) }}%</span>
                            </div>
                            <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $repaymentPercentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                You've repaid: <strong>KES {{ number_format($amountRepaid, 2) }}</strong><br>
                                Need to repay: <strong>KES {{ number_format($amountNeeded, 2) }} more</strong>
                            </p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('member.dashboard') }}"
                                class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium">
                                View My Loan Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =========================================== -->
            <!-- USER IS ELIGIBLE! SHOW THE TOP-UP FORM -->
            <!-- =========================================== -->
        @else
            <!-- USER IS ELIGIBLE - SHOW TOP-UP FORM -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
                <div class="flex items-center">
                    <span class="text-green-500 mr-3 text-2xl">✅</span>
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">You're Eligible for Top-up!</h3>
                        <p class="text-green-700 mt-1">
                            You've repaid <strong>{{ number_format($repaymentPercentage, 1) }}%</strong> of your current loan.
                            You can now apply for additional funds.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TOP-UP CALCULATOR FORM -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">🧮 Calculate Your Top-up</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Top-up Amount (KES)
                        </label>
                        <input type="range" id="topupAmount" min="10000" max="150000" step="1000" value="50000"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-sm text-gray-400 mt-2">
                            <span>KES 10,000</span>
                            <span id="topupAmountValue" class="font-bold text-gray-900">KES 50,000</span>
                            <span>KES 150,000</span>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Or enter specific amount:
                            </label>
                            <input type="number" id="topupAmountInput"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-lg font-bold text-center"
                                value="50000" min="10000" max="150000">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Repayment Period (Months)
                        </label>
                        <input type="range" id="topupPeriod" min="6" max="24" step="1" value="12"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-sm text-gray-400 mt-2">
                            <span>6 months</span>
                            <span id="topupPeriodValue" class="font-bold text-gray-900">12 months</span>
                            <span>24 months</span>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Top-up Purpose
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900">
                                <option>Business Expansion</option>
                                <option>Home Improvement</option>
                                <option>Education</option>
                                <option>Medical Expenses</option>
                                <option>Other Investment</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Calculation Results -->
                <div id="topupCalculation" class="mt-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                            <p class="text-sm text-gray-500">Top-up Amount</p>
                            <p id="calcTopupAmount" class="text-2xl font-bold text-gray-900">KES 50,000</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                            <p class="text-sm text-gray-500">Interest (5% Fixed)</p>
                            <p id="calcTopupInterest" class="text-2xl font-bold text-gray-900">KES 2,500</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                            <p class="text-sm text-gray-500">Total Repayable</p>
                            <p id="calcTopupTotal" class="text-2xl font-bold text-gray-900">KES 52,500</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <p class="font-semibold text-gray-900">Monthly Payment</p>
                            <p id="calcMonthlyPayment" class="text-3xl font-bold text-gray-900">KES 4,375</p>
                        </div>
                        <p class="text-sm text-gray-500">
                            For <span id="calcMonths">12</span> months at 5% fixed interest rate
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white py-4 rounded-lg font-semibold text-lg transition">
                        📝 Apply for Top-up Loan
                    </button>
                    <p class="text-sm text-gray-500 mt-4 text-center">
                        Total combined loans cannot exceed 1.5× your savings
                    </p>
                </div>
            </div>

            <!-- Eligibility Rules -->
            <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">📋 Top-up Rules</h2>

                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="text-green-600 mr-3">✅</span>
                        <div>
                            <p class="font-medium text-gray-900">50% Repayment Required</p>
                            <p class="text-gray-600 text-sm">Must repay at least half of current loan</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-blue-600 mr-3">💰</span>
                        <div>
                            <p class="font-medium text-gray-900">5% Fixed Interest Rate</p>
                            <p class="text-gray-600 text-sm">Same low rate as regular loans</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-purple-600 mr-3">📊</span>
                        <div>
                            <p class="font-medium text-gray-900">Combined Loan Limit</p>
                            <p class="text-gray-600 text-sm">All loans ≤ 1.5× your savings balance</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-yellow-600 mr-3">🎯</span>
                        <div>
                            <p class="font-medium text-gray-900">Example Scenario</p>
                            <p class="text-gray-600 text-sm">
                                Current loan: KES 150,000 (Repaid: KES 75,000)<br>
                                Savings: KES 200,000 → Can get up to KES 225,000 total loans
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        <!-- END OF ELIGIBILITY CHECK -->

    </div>

    <!-- JavaScript for Top-up Calculator -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Only run calculator if user is eligible
            @if($hasActiveLoan && $isEligible)
                const topupAmountSlider = document.getElementById('topupAmount');
                const topupAmountInput = document.getElementById('topupAmountInput');
                const topupAmountValue = document.getElementById('topupAmountValue');
                const topupPeriodSlider = document.getElementById('topupPeriod');
                const topupPeriodValue = document.getElementById('topupPeriodValue');

                const calcTopupAmount = document.getElementById('calcTopupAmount');
                const calcTopupInterest = document.getElementById('calcTopupInterest');
                const calcTopupTotal = document.getElementById('calcTopupTotal');
                const calcMonthlyPayment = document.getElementById('calcMonthlyPayment');
                const calcMonths = document.getElementById('calcMonths');

                const INTEREST_RATE = 0.05; // 5%

                function formatCurrency(amount) {
                    return 'KES ' + amount.toLocaleString('en-KE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                function calculateTopup() {
                    let amount = parseFloat(topupAmountInput.value);
                    let months = parseInt(topupPeriodSlider.value);

                    const interest = amount * INTEREST_RATE;
                    const total = amount + interest;
                    const monthly = total / months;

                    calcTopupAmount.textContent = formatCurrency(amount);
                    calcTopupInterest.textContent = formatCurrency(interest);
                    calcTopupTotal.textContent = formatCurrency(total);
                    calcMonthlyPayment.textContent = formatCurrency(monthly);
                    calcMonths.textContent = months;
                }

                function syncTopupAmount() {
                    let value = topupAmountSlider.value;
                    topupAmountInput.value = value;
                    topupAmountValue.textContent = formatCurrency(parseFloat(value));
                    calculateTopup();
                }

                function syncTopupPeriod() {
                    let months = topupPeriodSlider.value;
                    topupPeriodValue.textContent = `${months} months`;
                    calculateTopup();
                }

                // Event listeners
                topupAmountSlider.addEventListener('input', syncTopupAmount);
                topupAmountInput.addEventListener('input', function () {
                    let value = parseFloat(this.value);
                    if (value < 10000) value = 10000;
                    if (value > 150000) value = 150000;
                    this.value = value;
                    topupAmountSlider.value = value;
                    topupAmountValue.textContent = formatCurrency(value);
                    calculateTopup();
                });
                topupPeriodSlider.addEventListener('input', syncTopupPeriod);

                // Initial calculation
                syncTopupAmount();
                syncTopupPeriod();
            @endif
    });
    </script>
@endsection