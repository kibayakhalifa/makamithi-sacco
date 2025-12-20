

<?php $__env->startSection('title', 'Loan Assistance'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h1 class="text-2xl font-semibold text-gray-900">Loan Application Assistance</h1>
        <p class="text-gray-500 mt-1">Help members who need assistance with their loan applications</p>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
        <div class="flex items-start">
            <div class="text-blue-500 mr-3">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h3 class="font-medium text-gray-900 mb-1">How to Assist Members</h3>
                <p class="text-sm text-gray-700">Fill the loan application on behalf of the member. All applications require Chairman approval.</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <form action="<?php echo e(route('secretary.loans.assisted')); ?>" method="POST" enctype="multipart/form-data" id="loanApplicationForm">
            <?php echo csrf_field(); ?>
            
            <!-- Member Selection -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">1. Select Member</h3>
                
                <div class="mb-4">
                    <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Member *
                    </label>
                    <select name="member_id" id="member_id" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-500 focus:border-transparent" required>
                        <option value="">Select a member</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $savings = $member->savings->available_savings ?? 0;
                                $maxLoan = $savings * 1.5;
                            ?>
                            <option value="<?php echo e($member->id); ?>" 
                                    data-savings="<?php echo e($savings); ?>"
                                    data-max-loan="<?php echo e($maxLoan); ?>">
                                <?php echo e($member->name); ?> (<?php echo e($member->employee_number); ?>) - Savings: KES <?php echo e(number_format($savings, 2)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
                
                <!-- Member Info -->
                <div id="memberInfo" class="bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Available Savings:</p>
                            <p id="availableSavings" class="font-medium text-green-600">KES 0.00</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Max Loan Eligibility:</p>
                            <p id="loanEligibility" class="font-medium text-blue-600">KES 0.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Details -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">2. Loan Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Loan Amount (KES) *
                        </label>
                        <input type="number" name="amount" id="amount" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                               value="<?php echo e(old('amount')); ?>" min="1000" step="1000" required
                               placeholder="e.g., 50000"
                               oninput="calculateLoanPreview()">
                        <p class="text-xs text-gray-500 mt-1">Minimum: KES 1,000</p>
                    </div>

                    <div>
                        <label for="period_months" class="block text-sm font-medium text-gray-700 mb-2">
                            Repayment Period (Months) *
                        </label>
                        <input type="number" name="period_months" id="period_months" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                               value="<?php echo e(old('period_months')); ?>" min="1" max="60" required
                               placeholder="e.g., 12"
                               oninput="calculateLoanPreview()">
                        <p class="text-xs text-gray-500 mt-1">1 to 60 months</p>
                    </div>
                </div>

                <!-- Loan Type -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Loan Type *
                    </label>
                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <input type="radio" id="loan_type_first" name="loan_type" value="first_loan" 
                                   class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300" 
                                   <?php echo e(old('loan_type', 'first_loan') == 'first_loan' ? 'checked' : ''); ?> required>
                            <label for="loan_type_first" class="ml-2 block text-sm text-gray-700">
                                First Loan
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="loan_type_second" name="loan_type" value="second_loan" 
                                   class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300" 
                                   <?php echo e(old('loan_type') == 'second_loan' ? 'checked' : ''); ?>>
                            <label for="loan_type_second" class="ml-2 block text-sm text-gray-700">
                                Second Loan
                            </label>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Second loan requires completed first loan</p>
                </div>

                <!-- Purpose -->
                <div class="mt-6">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                        Loan Purpose *
                    </label>
                    <textarea name="purpose" id="purpose" rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                              placeholder="What will the loan be used for?" 
                              required><?php echo e(old('purpose')); ?></textarea>
                </div>

                <!-- Loan Preview -->
                <div id="loanPreview" class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200 hidden">
                    <h4 class="font-medium text-gray-900 mb-3">Loan Summary</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Principal Amount:</p>
                            <p id="previewPrincipal" class="font-medium">KES 0.00</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Interest (5%):</p>
                            <p id="previewInterest" class="font-medium text-blue-600">KES 0.00</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Repayable:</p>
                            <p id="previewTotal" class="font-medium text-green-600">KES 0.00</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Monthly Payment:</p>
                            <p id="previewMonthly" class="font-medium text-gray-900">KES 0.00</p>
                        </div>
                    </div>
                    <p id="paymentDuration" class="text-xs text-gray-500 mt-3">For 0 months</p>
                </div>
            </div>

            <!-- Document Upload -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">3. Upload Loan Application Form</h3>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition">
                    <div class="mb-4">
                        <i class="fas fa-file-upload text-3xl text-gray-400"></i>
                    </div>
                    <div class="mb-4">
                        <label for="loan_document" class="cursor-pointer">
                            <span class="text-gray-700 font-medium">Click to upload</span>
                            <p class="text-sm text-gray-500 mt-1">Upload the filled loan application form (PDF, DOC, JPEG, PNG)</p>
                        </label>
                        <input type="file" name="loan_document" id="loan_document" 
                               class="hidden" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                    
                    <!-- File Preview -->
                    <div id="filePreview" class="hidden mt-4">
                        <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <i class="fas fa-file text-blue-500 mr-3"></i>
                                <div>
                                    <p id="fileName" class="font-medium text-sm text-gray-900"></p>
                                    <p id="fileSize" class="text-xs text-gray-500"></p>
                                </div>
                            </div>
                            <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-4">
                        Max file size: 5MB. Required for record keeping.
                    </p>
                </div>
            </div>

            <!-- Warning -->
            <div id="eligibilityWarning" class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 hidden">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-sm text-red-700" id="warningMessage"></span>
                </div>
            </div>

            <!-- Terms -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="text-yellow-500 mr-3">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Important Information</h3>
                        <ul class="text-xs text-yellow-700 mt-1 list-disc pl-5 space-y-1">
                            <li>Loans issued at 1.5× member's savings</li>
                            <li>5% fixed interest rate</li>
                            <li>Requires Chairman approval</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                        <i class="fas fa-paper-plane mr-2"></i>Submit to Chairman
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Toasts -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
<div id="successToast" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
<div id="errorToast" class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Show/hide member info
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
            const interestRate = 0.05;
            const interestAmount = amount * interestRate * (period / 12);
            const totalRepayable = amount + interestAmount;
            const monthlyPayment = period > 0 ? totalRepayable / period : 0;
            
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
            validateLoanAmount();
        } else {
            loanPreview.classList.add('hidden');
        }
    }
    
    // Validate loan amount
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
                document.getElementById('amount').classList.add('border-red-300');
            } else {
                warningDiv.classList.add('hidden');
                document.getElementById('amount').classList.remove('border-red-300');
            }
        }
    }
    
    // File upload handling
    document.getElementById('loan_document').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        if (file) {
            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                this.value = '';
                return;
            }
            
            // Check file type
            const validTypes = ['application/pdf', 'application/msword', 
                              'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                              'image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload PDF, DOC, or image files only');
                this.value = '';
                return;
            }
            
            // Show file preview
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
            filePreview.classList.remove('hidden');
        }
    });
    
    function removeFile() {
        document.getElementById('loan_document').value = '';
        document.getElementById('filePreview').classList.add('hidden');
    }
    
    // Form validation
    document.getElementById('loanApplicationForm').addEventListener('submit', function(e) {
        const memberId = document.getElementById('member_id').value;
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const period = document.getElementById('period_months').value;
        const purpose = document.getElementById('purpose').value.trim();
        const loanDocument = document.getElementById('loan_document').files[0];
        
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
        
        if (!period || period < 1 || period > 60) {
            e.preventDefault();
            alert('Please enter a valid repayment period (1-60 months)');
            return false;
        }
        
        if (!purpose) {
            e.preventDefault();
            alert('Please enter the loan purpose');
            return false;
        }
        
        if (!loanDocument) {
            e.preventDefault();
            alert('Please upload the loan application form document');
            return false;
        }
        
        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            submitBtn.disabled = true;
        }
    });
    
    // Auto-hide toasts
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('#successToast, #errorToast');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        });
        
        if (document.getElementById('amount').value) {
            calculateLoanPreview();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/loan-assist.blade.php ENDPATH**/ ?>