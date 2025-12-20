<?php $__env->startSection('title', 'Apply for Loan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Apply for a Loan</h1>
                    <p class="text-blue-800 text-sm mt-1">Get quick access to funds based on your savings</p>
                </div>
                <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                    <p class="text-gray-600 text-xs">Your Loan Eligibility</p>
                    <p class="text-xl font-bold text-blue-600">KES <?php echo e(number_format($eligibility, 2)); ?></p>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActiveFirstLoan): ?>
            <!-- Active Loan Status -->
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full <?php echo e($isEligibleForSecondLoan ? 'bg-green-100' : 'bg-yellow-100'); ?> flex items-center justify-center">
                            <span class="<?php echo e($isEligibleForSecondLoan ? 'text-green-600' : 'text-yellow-600'); ?>">📋</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Your Current Loan</h3>
                        <p class="text-sm text-gray-600">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEligibleForSecondLoan): ?>
                                ✅ Eligible for a Second Loan
                            <?php else: ?>
                                ⏳ Pay 50% to qualify for Second Loan
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstLoan): ?>
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($firstLoan->loan_number); ?></p>
                                <p class="text-xs text-gray-600">Balance: KES <?php echo e(number_format($firstLoan->remaining_balance, 0)); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold <?php echo e($isEligibleForSecondLoan ? 'text-green-600' : 'text-yellow-600'); ?>">
                                    <?php echo e(number_format($firstLoan->percentage_paid, 1)); ?>% Paid
                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isEligibleForSecondLoan): ?>
                                    <p class="text-xs text-red-600"><?php echo e(max(0, 50 - $firstLoan->percentage_paid)); ?>% to go</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="<?php echo e($isEligibleForSecondLoan ? 'bg-green-600' : 'bg-yellow-600'); ?> h-1.5 rounded-full" 
                                  style="width: <?php echo e(min($firstLoan->percentage_paid, 100)); ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Loan Type Selection -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h2 class="font-bold text-gray-900 mb-3">1. Select Loan Type</h2>

                    <div class="space-y-2">
                        <!-- First Loan -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$hasActiveFirstLoan): ?>
                            <label class="flex items-center p-3 border border-blue-300 rounded-lg cursor-pointer hover:bg-blue-50 transition bg-blue-50">
                                <input type="radio" name="loan_type" value="first" checked class="w-4 h-4 text-blue-600">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-900">First Loan</p>
                                    <p class="text-xs text-gray-600">Apply for your initial loan</p>
                                </div>
                            </label>
                        <?php else: ?>
                            <!-- First Loan Disabled -->
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50 opacity-60">
                                <input type="radio" name="loan_type" value="first" disabled class="w-4 h-4 text-gray-400">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-600">First Loan</p>
                                    <p class="text-xs text-gray-500">Already taken</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Second Loan -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActiveFirstLoan && $isEligibleForSecondLoan): ?>
                            <label class="flex items-center p-3 border border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="loan_type" value="second" checked class="w-4 h-4 text-green-600">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-900">Second Loan ✓</p>
                                    <p class="text-xs text-gray-600">Apply for an additional new loan</p>
                                    <p class="text-xs text-green-600 mt-1">Eligible - <?php echo e(number_format($firstLoan->percentage_paid, 1)); ?>% repaid</p>
                                </div>
                            </label>
                        <?php elseif($hasActiveFirstLoan && !$isEligibleForSecondLoan): ?>
                            <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50 opacity-60">
                                <input type="radio" name="loan_type" value="second" disabled class="w-4 h-4 text-gray-400">
                                <div class="ml-3 flex-1">
                                    <p class="font-semibold text-sm text-gray-600">Second Loan</p>
                                    <p class="text-xs text-gray-500">Requires 50% repayment of first loan</p>
                                    <p class="text-xs text-red-600 mt-1"><?php echo e(number_format($firstLoan->percentage_paid ?? 0, 1)); ?>% repaid - Need 50%</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((!$hasActiveFirstLoan) || ($hasActiveFirstLoan && $isEligibleForSecondLoan)): ?>
                <!-- Loan Details Form -->
                <form action="<?php echo e(route('member.loans.store')); ?>" method="POST" enctype="multipart/form-data" 
                      id="loanForm" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="loan_type" id="selectedLoanType" value="<?php echo e(!$hasActiveFirstLoan ? 'first' : 'second'); ?>">

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
                                        max="<?php echo e($hasActiveFirstLoan && $isEligibleForSecondLoan ? ($secondLoanEligibility ?? $eligibility) : $eligibility); ?>" 
                                        step="1000"
                                        value="<?php echo e(old('amount')); ?>"
                                        class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="50,000"
                                        oninput="updateRepaymentSchedule()">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Max: KES <?php echo e(number_format($hasActiveFirstLoan && $isEligibleForSecondLoan ? ($secondLoanEligibility ?? $eligibility) : $eligibility, 2)); ?>

                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Repayment Period (Months)</label>
                                    <div class="relative">
                                        <input type="number" name="period_months" id="periodMonths" required 
                                            min="6" max="60" step="1"
                                            value="<?php echo e(old('period_months', 12)); ?>"
                                            class="w-full pl-3 pr-8 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="12"
                                            oninput="updateRepaymentSchedule()">
                                        <span class="absolute right-3 top-3 text-gray-500 text-sm">months</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">6 - 60 months</p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['period_months'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1">Purpose</label>
                                    <input type="text" name="purpose" required 
                                        value="<?php echo e(old('purpose')); ?>"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="e.g., Home improvement, Education">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Loan Application Form</label>
                                <div class="flex items-center gap-2">
                                    <input type="file" name="support_document" id="supportDocument" 
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="hidden"
                                        onchange="updateFileName()">
                                    <label for="supportDocument" 
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-600">
                                        <span id="fileName">Choose file...</span>
                                    </label>
                                    <button type="button" onclick="document.getElementById('supportDocument').click()"
                                        class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                                        Browse
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (max 5MB)</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['support_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['agree_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3">
                        <a href="<?php echo e(route('member.dashboard')); ?>"
                            class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition text-sm">
                            Submit Application
                        </button>
                    </div>
                </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>

            <!-- Sidebar -->
            <div class="space-y-5">

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
        const fileName = document.getElementById('fileName');

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

        function updateFileName() {
            const fileInput = document.getElementById('supportDocument');
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Choose file...';
            }
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

        // Event listeners
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

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            if (loanAmountInput && loanAmountInput.value) {
                loanAmountInput.value = Math.max(5000, Math.min(loanAmountInput.value, loanAmountInput.max));
            }
            
            if (periodInput && periodInput.value) {
                periodInput.value = Math.max(6, Math.min(periodInput.value, 60));
            }
            
            updateRepaymentSchedule();
        });

        // Form validation
        const loanForm = document.getElementById('loanForm');
        if (loanForm) {
            loanForm.addEventListener('submit', function(e) {
                const amount = parseFloat(loanAmountInput.value) || 0;
                const months = parseInt(periodInput.value) || 0;
                
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
                
                if (!document.querySelector('input[name="agree_terms"]:checked')) {
                    e.preventDefault();
                    alert('You must agree to the terms and conditions.');
                    return;
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/apply.blade.php ENDPATH**/ ?>