

<?php $__env->startSection('title', 'Make Payment'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Make Payment</h1>
            <p class="text-gray-500 mt-1">Payment for loan #<?php echo e($loan->loan_number); ?></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Details</h2>
                    
                    <form action="#" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Loan Number</label>
                                <input type="text" value="<?php echo e($loan->loan_number); ?>" readonly 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Loan Balance</label>
                                <input type="text" value="KES <?php echo e(number_format($loan->remaining_balance, 2)); ?>" readonly 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Amount to Pay (KES)</label>
                                <input type="number" name="amount" required min="100" 
                                    max="<?php echo e($loan->remaining_balance); ?>" step="100"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Enter amount">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Payment Method</label>
                                <select name="payment_method" required 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Select method</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Payment Date</label>
                                <input type="date" name="payment_date" required 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    value="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Reference/Transaction ID</label>
                                <input type="text" name="reference" 
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Enter transaction reference">
                            </div>
                        </div>
                        
                        <div class="flex gap-3 mt-6">
                            <a href="<?php echo e(route('member.loans.show', $loan->id)); ?>"
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-sm text-center">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition text-sm">
                                Submit Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Loan Summary -->
            <div>
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Loan Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Loan Type:</span>
                            <span class="font-medium text-gray-900 text-sm">
                                <?php echo e($loan->loan_type === 'first_loan' ? 'First Loan' : 'Second Loan'); ?>

                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Original Amount:</span>
                            <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($loan->amount, 2)); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Total Repayable:</span>
                            <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($loan->total_repayable, 2)); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Amount Paid:</span>
                            <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($loan->amount_paid, 2)); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Remaining Balance:</span>
                            <span class="font-medium text-gray-900 text-sm">KES <?php echo e(number_format($loan->remaining_balance, 2)); ?></span>
                        </div>
                        
                        <div class="pt-3 border-t">
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-600 text-sm">Progress:</span>
                                <span class="font-medium text-gray-900 text-sm"><?php echo e(number_format($loan->percentage_paid, 1)); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: <?php echo e(min($loan->percentage_paid, 100)); ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/payments/create.blade.php ENDPATH**/ ?>