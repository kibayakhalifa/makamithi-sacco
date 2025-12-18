

<?php $__env->startSection('title', 'My Savings'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Savings Account</h1>
                <p class="text-green-800 mt-2">Track your savings growth and manage your account</p>
            </div>
            <div class="flex gap-3">
                <button onclick="document.getElementById('topupModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    💰 Top-up Savings
                </button>
                <button onclick="document.getElementById('withdrawalModal').classList.remove('hidden')" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    💸 Request Withdrawal
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Available Savings -->
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Available Savings</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">KES <?php echo e(number_format($savings->available_savings, 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Ready for withdrawal</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <span class="text-green-600 text-2xl">💰</span>
                </div>
            </div>
        </div>

        <!-- Loan Eligibility -->
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Loan Eligibility</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">KES <?php echo e(number_format($stats['loan_qualification'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">1.5× your savings</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <span class="text-blue-600 text-2xl">📊</span>
                </div>
            </div>
        </div>

        <!-- Interest Earned -->
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">Interest Earned</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">KES <?php echo e(number_format($stats['interest_earned'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Total interest</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <span class="text-purple-600 text-2xl">📈</span>
                </div>
            </div>
        </div>

        <!-- Year to Date -->
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-xs uppercase tracking-wider font-medium">This Year</h3>
                    <p class="text-3xl font-bold text-orange-600 mt-2">KES <?php echo e(number_format($stats['year_to_date'], 2)); ?></p>
                    <p class="text-gray-500 text-sm mt-1">Total saved <?php echo e(date('Y')); ?></p>
                </div>
                <div class="bg-orange-100 p-3 rounded-xl">
                    <span class="text-orange-600 text-2xl">🎯</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Growth Summary -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($growthData && count($growthData) > 0): ?>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Savings Growth (Last 12 Months)</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-300">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Month</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Monthly Deposit</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Cumulative Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $growthData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-900 font-medium border-r border-gray-300"><?php echo e($data['month']); ?></td>
                        <td class="px-4 py-3 text-right text-green-600 font-semibold border-r border-gray-300">
                            KES <?php echo e(number_format($data['deposits'], 2)); ?>

                        </td>
                        <td class="px-4 py-3 text-right text-gray-900 font-semibold">
                            KES <?php echo e(number_format($data['cumulative'], 2)); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Transactions</h2>
            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All →</a>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transactions && $transactions->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b-2 border-gray-300">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">No.</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Description</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Amount</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Balance</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase border-r border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-sm text-gray-900 font-medium border-r border-gray-300"><?php echo e(($transactions->currentPage() - 1) * $transactions->perPage() + $index + 1); ?></td>
                                <td class="px-4 py-4 text-sm text-gray-900 border-r border-gray-300">
                                    <?php echo e($transaction->transaction_date->format('d M Y') ?? $transaction->created_at->format('d M Y')); ?>

                                </td>
                                <td class="px-4 py-4 text-sm border-r border-gray-300">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($transaction->type, ['payroll_deduction', 'voluntary_deposit', 'interest_credit'])): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium"><?php echo e(ucfirst(str_replace('_', ' ', $transaction->type))); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium"><?php echo e(ucfirst(str_replace('_', ' ', $transaction->type))); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 border-r border-gray-300"><?php echo e($transaction->description); ?></td>
                                <td class="px-4 py-4 text-sm text-right font-semibold border-r border-gray-300 <?php echo e($transaction->amount > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($transaction->amount > 0 ? '+' : ''); ?>KES <?php echo e(number_format(abs($transaction->amount), 2)); ?>

                                </td>
                                <td class="px-4 py-4 text-sm text-right text-gray-900 font-medium border-r border-gray-300">KES <?php echo e(number_format($transaction->balance_after, 2)); ?></td>
                                <td class="px-4 py-4 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status === 'completed'): ?>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">✓ Completed</span>
                                    <?php elseif($transaction->status === 'pending'): ?>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">⏳ Pending</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">✗ <?php echo e(ucfirst($transaction->status)); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transactions instanceof \Illuminate\Pagination\Paginator): ?>
                <div class="mt-4">
                    <?php echo e($transactions->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No transactions yet</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>

<!-- Top-up Modal -->
<div id="topupModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-900">Top-up Savings</h2>
            <p class="text-gray-600 text-sm mt-1">Add funds to your savings account</p>
        </div>

        <form action="<?php echo e(route('member.savings.topup')); ?>" method="POST" class="p-6 space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Amount (KES)</label>
                <input type="number" name="amount" required min="100" step="100" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="1,000">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Payment Method</label>
                <select name="payment_method" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Select payment method</option>
                    <option value="mpesa">M-Pesa</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                    <option value="cash">Cash</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Reference (Optional)</label>
                <input type="text" name="reference" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="Transaction reference">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Notes (Optional)</label>
                <textarea name="notes" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                          placeholder="Any additional notes"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('topupModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    Top-up Now
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Withdrawal Modal -->
<div id="withdrawalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-900">Request Withdrawal</h2>
            <p class="text-gray-600 text-sm mt-1">Submit a withdrawal request for your savings</p>
        </div>

        <form action="<?php echo e(route('member.savings.withdrawal-request')); ?>" method="POST" class="p-6 space-y-4">
            <?php echo csrf_field(); ?>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-amber-800">
                    <strong>Note:</strong> Withdrawals are only processed upon resignation, retirement, or in specific circumstances. A KES 2,000 retention will apply.
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Withdrawal Amount (KES)</label>
                <p class="text-xs text-gray-500 mb-2">Maximum: KES <?php echo e(number_format($savings->available_savings > 2000 ? $savings->available_savings - 2000 : 0, 2)); ?></p>
                <input type="number" name="amount" required min="1000" max="<?php echo e($savings->available_savings - 2000); ?>" step="100"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                       placeholder="Amount">
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
                <label class="block text-sm font-medium text-gray-900 mb-1">Reason for Withdrawal</label>
                <select name="withdrawal_reason" required id="withdrawal_reason" onchange="updateWithdrawalAmount()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Select a reason</option>
                    <option value="resignation">Resignation</option>
                    <option value="retirement">Retirement</option>
                    <option value="medical_emergency">Medical Emergency</option>
                    <option value="other">Other</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['withdrawal_reason'];
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

            <div id="withdrawalWarning" class="hidden bg-red-50 border border-red-200 rounded-lg p-3">
                <p class="text-sm text-red-800">This action cannot be undone. Your savings account will be reduced.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Payment Method</label>
                <select name="payment_method" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Select payment method</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="mpesa">M-Pesa</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>

            <!-- Bank Transfer Details -->
            <div id="bankDetails" class="hidden space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Bank Name</label>
                    <input type="text" name="bank_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Bank name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Account Number</label>
                    <input type="text" name="bank_account_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Account number">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Account Name</label>
                    <input type="text" name="bank_account_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Account name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Branch</label>
                    <input type="text" name="bank_branch" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Branch">
                </div>
            </div>

            <!-- M-Pesa Details -->
            <div id="mpesaDetails" class="hidden space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">M-Pesa Number *</label>
                    <input type="text" name="mpesa_number" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg" 
                        placeholder="07XX XXX XXX"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-1">Additional Notes (Optional)</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Any additional information"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('withdrawalModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                    Request Withdrawal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Fix for withdrawal modal payment method toggle
document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle payment details based on selected method
    function toggleWithdrawalPaymentDetails() {
        const paymentSelect = document.querySelector('#withdrawalModal select[name="payment_method"]');
        const bankDetails = document.getElementById('bankDetails');
        const mpesaDetails = document.getElementById('mpesaDetails');
        
        if (!paymentSelect || !bankDetails || !mpesaDetails) return;
        
        const value = paymentSelect.value;
        
        if (value === 'bank_transfer') {
            bankDetails.classList.remove('hidden');
            mpesaDetails.classList.add('hidden');
            // Make bank fields required
            bankDetails.querySelectorAll('input').forEach(input => {
                input.required = true;
                input.disabled = false;
            });
            // Make M-Pesa fields not required
            mpesaDetails.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });
        } else if (value === 'mpesa') {
            bankDetails.classList.add('hidden');
            mpesaDetails.classList.remove('hidden');
            // Make bank fields not required
            bankDetails.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });
            // Make M-Pesa field required
            mpesaDetails.querySelectorAll('input').forEach(input => {
                input.required = true;
                input.disabled = false;
            });
        } else {
            bankDetails.classList.add('hidden');
            mpesaDetails.classList.add('hidden');
            // Remove required from all
            bankDetails.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });
            mpesaDetails.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });
        }
    }
    
    // Set up payment method toggle for withdrawal modal
    const withdrawalPaymentSelect = document.querySelector('#withdrawalModal select[name="payment_method"]');
    if (withdrawalPaymentSelect) {
        withdrawalPaymentSelect.addEventListener('change', toggleWithdrawalPaymentDetails);
        // Initialize on page load
        toggleWithdrawalPaymentDetails();
    }
    
    // Set up payment method toggle for topup modal (if needed)
    const topupPaymentSelect = document.querySelector('#topupModal select[name="payment_method"]');
    if (topupPaymentSelect) {
        topupPaymentSelect.addEventListener('change', function() {
            // Add any topup-specific logic here if needed
            console.log('Topup payment method changed to:', this.value);
        });
    }
    
    // Close modals when clicking outside
    document.getElementById('topupModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
    
    document.getElementById('withdrawalModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('topupModal')?.classList.add('hidden');
            document.getElementById('withdrawalModal')?.classList.add('hidden');
        }
    });
    
    // Update withdrawal amount warning
    function updateWithdrawalAmount() {
        const reason = document.getElementById('withdrawal_reason')?.value;
        const warning = document.getElementById('withdrawalWarning');
        if (warning) {
            warning.style.display = reason ? 'block' : 'none';
        }
    }
    
    const withdrawalReasonSelect = document.getElementById('withdrawal_reason');
    if (withdrawalReasonSelect) {
        withdrawalReasonSelect.addEventListener('change', updateWithdrawalAmount);
    }
    
    // Initialize everything
    console.log('Savings page JavaScript loaded successfully');
    
    // Debug helper: show which modal elements exist
    console.log('Topup Modal:', document.getElementById('topupModal') ? 'Exists' : 'Not found');
    console.log('Withdrawal Modal:', document.getElementById('withdrawalModal') ? 'Exists' : 'Not found');
    console.log('Withdrawal Payment Select:', withdrawalPaymentSelect ? 'Exists' : 'Not found');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/savings/index.blade.php ENDPATH**/ ?>