

<?php $__env->startSection('title', 'Apply for Loan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Apply for a Loan</h1>
                    <p class="text-blue-800 mt-2">Get quick access to funds based on your savings</p>
                </div>
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                    <p class="text-gray-600 text-sm">Your Loan Eligibility</p>
                    <p class="text-2xl font-bold text-blue-600">KES <?php echo e(number_format($eligibility, 2)); ?></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Loan Type Selection -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">1. Select Loan Type</h2>

                    <div class="space-y-3">
                        <!-- Normal Loan -->
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="loan_type" value="normal" checked class="w-4 h-4 text-blue-600">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-900">Normal Loan</p>
                                <p class="text-sm text-gray-600">First-time loan based on your savings</p>
                                <p class="text-xs text-blue-600 mt-1">Max: 1.5× your savings (KES
                                    <?php echo e(number_format($eligibility, 2)); ?>)
                                </p>
                            </div>
                        </label>

                        <!-- Top-up Loan (if eligible) -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActiveLoan): ?>
                            <label
                                class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="loan_type" value="topup" class="w-4 h-4 text-green-600">
                                <div class="ml-4 flex-1">
                                    <p class="font-semibold text-gray-900">Top-up Loan ✓</p>
                                    <p class="text-sm text-gray-600">Additional loan on your active loan (requires 50%
                                        repayment)</p>
                                    <p class="text-xs text-green-600 mt-1">Available once you've paid 50% of current loan</p>
                                </div>
                            </label>
                        <?php else: ?>
                            <div class="flex items-center p-4 border border-gray-300 rounded-lg bg-gray-50 opacity-60">
                                <input type="radio" name="loan_type" value="topup" disabled class="w-4 h-4 text-gray-400">
                                <div class="ml-4 flex-1">
                                    <p class="font-semibold text-gray-600">Top-up Loan (Not Available)</p>
                                    <p class="text-sm text-gray-500">You need an active loan to apply for a top-up</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Loan Details Form -->
                <form action="<?php echo e(route('member.loans.store')); ?>" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <!-- Loan Amount -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">2. Loan Details</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Loan Amount (KES)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-500">KES</span>
                                    <input type="number" name="amount" required min="5000" max="<?php echo e($eligibility); ?>"
                                        step="1000"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="50,000" @change="updateRepaymentSchedule()">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Minimum: KES 5,000 | Maximum: KES
                                    <?php echo e(number_format($eligibility, 2)); ?>

                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Repayment Period
                                    (Months)</label>
                                <select name="period_months" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    @change="updateRepaymentSchedule()">
                                    <option value="">Select period</option>
                                    <option value="6">6 months</option>
                                    <option value="12">12 months</option>
                                    <option value="18">18 months</option>
                                    <option value="24">24 months</option>
                                    <option value="36">36 months</option>
                                    <option value="48">48 months</option>
                                    <option value="60">60 months</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['period_months'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Purpose of Loan</label>
                                <textarea name="purpose" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Briefly explain how you intend to use this loan..."><?php echo e(old('purpose')); ?></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-2">Support Document
                                    (optional)</label>
                                <input type="file" name="support_document" accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-2">Upload proof (pay slips, invoice, or any supporting
                                    PDF/image). Max 5MB.</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['support_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">3. Terms & Conditions</h2>

                        <div class="space-y-3 mb-4 text-sm text-gray-600">
                            <p>✓ I confirm that the information provided is accurate and complete</p>
                            <p>✓ I understand the loan will be disbursed to my designated account</p>
                            <p>✓ I agree to repay the loan with interest as per the agreed schedule</p>
                        </div>

                        <label class="flex items-center">
                            <input type="checkbox" name="agree_terms" required class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-3 text-sm text-gray-700">I agree to the above terms and conditions</span>
                        </label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['agree_terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3">
                        <a href="<?php echo e(route('member.dashboard')); ?>"
                            class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            Submit Application
                        </button>
                    </div>
                </form>

            </div>

            <!-- Sidebar: How It Works + Calculator -->
            <div class="space-y-6">

                <!-- Quick Calculator -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 ">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">💡 Repayment Calculator</h3>

                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="text-gray-600">Loan Amount</label>
                            <p class="text-2xl font-bold text-blue-600" id="calcAmount">KES 0</p>
                        </div>
                        <div class="border-t pt-4">
                            <label class="text-gray-600">Repayment Period</label>
                            <p class="text-lg font-semibold text-gray-900" id="calcPeriod">- months</p>
                        </div>
                        <div class="border-t pt-4">
                            <label class="text-gray-600">Interest Rate</label>
                            <p class="text-lg font-semibold text-gray-900">5% p.a.</p>
                        </div>
                        <div class="border-t pt-4 bg-blue-50 rounded p-3">
                            <label class="text-gray-600 text-xs uppercase">Monthly Payment</label>
                            <p class="text-2xl font-bold text-blue-600" id="monthlyPayment">KES 0</p>
                        </div>
                    </div>
                </div>

                <!-- How It Works -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📋 How It Works</h3>

                    <div class="space-y-4 text-sm">
                        <div class="flex gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                1</div>
                            <div>
                                <p class="font-semibold text-gray-900">Submit Application</p>
                                <p class="text-gray-600">Provide loan details and purpose</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                2</div>
                            <div>
                                <p class="font-semibold text-gray-900">Chairman Review</p>
                                <p class="text-gray-600">Approved by leadership</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                3</div>
                            <div>
                                <p class="font-semibold text-gray-900">Funds Disbursed</p>
                                <p class="text-gray-600">Transferred to your account</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                4</div>
                            <div>
                                <p class="font-semibold text-gray-900">Repay Monthly</p>
                                <p class="text-gray-600">Fixed installments deducted from salary</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">⚠️ Requirements</h3>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li>✓ Active savings account</li>
                        <li>✓ Minimum savings: KES 1,000</li>
                        <li>✓ Employed member</li>
                        <li>✓ No pending disciplinary issues</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

    <script>
        // Calculator functionality
        const loanAmountInput = document.querySelector('input[name="amount"]');
        const periodSelect = document.querySelector('select[name="period_months"]');
        const calcAmount = document.getElementById('calcAmount');
        const calcPeriod = document.getElementById('calcPeriod');
        const monthlyPayment = document.getElementById('monthlyPayment');

        const interestRate = 0.05; // 5% per annum

        function updateRepaymentSchedule() {
            const amount = parseFloat(loanAmountInput.value) || 0;
            const months = parseInt(periodSelect.value) || 0;

            calcAmount.textContent = 'KES ' + amount.toLocaleString('en-US', { maximumFractionDigits: 0 });
            calcPeriod.textContent = months + ' months';

            if (amount > 0 && months > 0) {
                // Calculate monthly interest rate
                const monthlyRate = interestRate / 12;

                // Calculate monthly payment using loan formula
                const monthlyPaymentAmount = (amount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));

                monthlyPayment.textContent = 'KES ' + monthlyPaymentAmount.toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
            } else {
                monthlyPayment.textContent = 'KES 0';
            }
        }

        // Add event listeners
        if (loanAmountInput) loanAmountInput.addEventListener('change', updateRepaymentSchedule);
        if (periodSelect) periodSelect.addEventListener('change', updateRepaymentSchedule);

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateRepaymentSchedule);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/apply.blade.php ENDPATH**/ ?>