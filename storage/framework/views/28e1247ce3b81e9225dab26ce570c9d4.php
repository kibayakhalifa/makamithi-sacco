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

            <!-- Document Upload - SIMPLIFIED FIXED VERSION -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">3. Upload Loan Application Form</h3>
                
                <!-- Simple file input with custom styling -->
                <div class="mb-4">
                    <label for="loan_document" class="block text-sm font-medium text-gray-700 mb-2">
                        Loan Document *
                    </label>
                    <div class="relative">
                        <input type="file" 
                               name="loan_document" 
                               id="loan_document" 
                               class="w-full text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-800 cursor-pointer border border-gray-300 rounded-lg"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               onchange="handleFileSelect(this)">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Supported: PDF, DOC, JPEG, PNG (Max: 5MB)</p>
                </div>
                
                <!-- Upload Progress Bar -->
                <div id="uploadProgress" class="hidden mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p id="progressText" class="text-xs text-gray-600 mt-2">Uploading...</p>
                </div>
                
                <!-- File Preview -->
                <div id="filePreview" class="hidden mt-6">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        <div class="flex items-center justify-between p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div id="fileIcon" class="w-12 h-12 flex items-center justify-center rounded-lg">
                                        <!-- Icon will be set dynamically -->
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p id="fileName" class="font-medium text-gray-900 truncate"></p>
                                    <div class="flex items-center mt-1">
                                        <span id="fileSize" class="text-sm text-gray-500 mr-3"></span>
                                        <span id="fileType" class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="previewFile()" 
                                        class="flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                                    <i class="fas fa-eye mr-2"></i>Preview
                                </button>
                                <button type="button" onclick="removeFile()" 
                                        class="flex items-center text-red-600 hover:text-red-800 text-sm font-medium px-4 py-2 rounded-lg hover:bg-red-50 transition">
                                    <i class="fas fa-times mr-2"></i>Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Modal -->
                <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl">
                        <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-900" id="previewTitle"></h3>
                            <div class="flex items-center space-x-2">
                                <button type="button" onclick="downloadFile()" 
                                        class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button type="button" onclick="closePreview()" 
                                        class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4 overflow-auto max-h-[70vh]">
                            <iframe id="previewFrame" class="w-full h-[500px] border-0 rounded-lg" style="display: none;"></iframe>
                            <img id="imagePreview" class="max-w-full h-auto mx-auto rounded-lg shadow-lg" style="display: none;" />
                            <div id="unsupportedPreview" class="text-center p-8" style="display: none;">
                                <i class="fas fa-file text-5xl text-gray-400 mb-4"></i>
                                <p class="text-gray-700 font-medium">Preview not available</p>
                                <p class="text-sm text-gray-500 mt-2">This file type cannot be previewed in the browser.</p>
                                <button type="button" onclick="downloadFile()" 
                                        class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                    <i class="fas fa-download mr-2"></i>Download File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Upload Requirements -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <h4 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Upload Requirements:
                    </h4>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Signed loan application form (required for approval)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>Clear scan or photo of the document</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 flex-shrink-0"></i>
                            <span>All text should be readable</span>
                        </li>
                    </ul>
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
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span id="uploadStatus" class="hidden">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            <span class="font-medium">Document uploaded</span>
                        </span>
                    </div>
                    <div>
                        <button type="submit" id="submitBtn" class="px-8 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>Submit to Chairman
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Toasts -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
<div id="successToast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center">
    <i class="fas fa-check-circle mr-3"></i>
    <span><?php echo e(session('success')); ?></span>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
<div id="errorToast" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center">
    <i class="fas fa-exclamation-circle mr-3"></i>
    <span><?php echo e(session('error')); ?></span>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom file input styling */
    input[type="file"]::file-selector-button {
        margin-right: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        background-color: #111827;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    input[type="file"]::file-selector-button:hover {
        background-color: #1f2937;
    }
    
    .file-icon-pdf { background-color: #FEE2E2; color: #DC2626; }
    .file-icon-doc { background-color: #DBEAFE; color: #1D4ED8; }
    .file-icon-img { background-color: #DCFCE7; color: #16A34A; }
    .file-icon-other { background-color: #F3E8FF; color: #7C3AED; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let currentFile = null;
    let fileUrl = null;
    
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
    
    // File upload handling - SIMPLIFIED
    function handleFileSelect(input) {
        const file = input.files[0];
        if (file) {
            handleFileUpload(file);
        }
    }
    
    function handleFileUpload(file) {
        if (!file) return;
        
        // Check file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            showToast('File size must be less than 5MB', 'error');
            document.getElementById('loan_document').value = '';
            return;
        }
        
        // Check file type
        const validTypes = ['application/pdf', 'application/msword', 
                          'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                          'image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            showToast('Please upload PDF, DOC, or image files only', 'error');
            document.getElementById('loan_document').value = '';
            return;
        }
        
        currentFile = file;
        
        // Show upload progress
        const progressDiv = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        
        progressDiv.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.textContent = 'Starting upload...';
        
        // Simulate upload progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 20;
            if (progress > 100) progress = 100;
            
            progressBar.style.width = progress + '%';
            progressText.textContent = progress === 100 ? 'Processing file...' : `Uploading... ${Math.round(progress)}%`;
            
            if (progress === 100) {
                clearInterval(interval);
                setTimeout(() => {
                    progressDiv.classList.add('hidden');
                    showFilePreview(file);
                }, 500);
            }
        }, 200);
    }
    
    function showFilePreview(file) {
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileType = document.getElementById('fileType');
        const fileIcon = document.getElementById('fileIcon');
        const uploadStatus = document.getElementById('uploadStatus');
        
        // Set file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        // Set file type label
        let typeLabel = 'Unknown';
        let iconClass = 'file-icon-other';
        let iconHtml = '<i class="fas fa-file text-xl"></i>';
        
        if (file.type === 'application/pdf') {
            typeLabel = 'PDF';
            iconClass = 'file-icon-pdf';
            iconHtml = '<i class="fas fa-file-pdf text-xl"></i>';
        } else if (file.type.includes('msword') || file.type.includes('wordprocessingml')) {
            typeLabel = 'DOC';
            iconClass = 'file-icon-doc';
            iconHtml = '<i class="fas fa-file-word text-xl"></i>';
        } else if (file.type.includes('image')) {
            typeLabel = 'IMAGE';
            iconClass = 'file-icon-img';
            iconHtml = '<i class="fas fa-file-image text-xl"></i>';
        }
        
        fileType.textContent = typeLabel;
        fileIcon.className = `w-12 h-12 flex items-center justify-center rounded-lg ${iconClass}`;
        fileIcon.innerHTML = iconHtml;
        
        // Show preview and status
        filePreview.classList.remove('hidden');
        uploadStatus.classList.remove('hidden');
        uploadStatus.innerHTML = `<i class="fas fa-check-circle text-green-500 mr-2"></i><span class="font-medium">${file.name} uploaded</span>`;
        
        // Create object URL for preview
        fileUrl = URL.createObjectURL(file);
        
        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit to Chairman';
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }
    
    function previewFile() {
        if (!currentFile || !fileUrl) return;
        
        const modal = document.getElementById('previewModal');
        const title = document.getElementById('previewTitle');
        const iframe = document.getElementById('previewFrame');
        const image = document.getElementById('imagePreview');
        const unsupported = document.getElementById('unsupportedPreview');
        
        title.textContent = currentFile.name;
        
        // Reset all displays
        iframe.style.display = 'none';
        image.style.display = 'none';
        unsupported.style.display = 'none';
        
        // Show appropriate preview
        if (currentFile.type === 'application/pdf') {
            iframe.src = fileUrl;
            iframe.style.display = 'block';
        } else if (currentFile.type.includes('image')) {
            image.src = fileUrl;
            image.style.display = 'block';
        } else {
            unsupported.style.display = 'block';
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closePreview() {
        const modal = document.getElementById('previewModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function downloadFile() {
        if (!currentFile || !fileUrl) return;
        
        const a = document.createElement('a');
        a.href = fileUrl;
        a.download = currentFile.name;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
    
    function removeFile() {
        const filePreview = document.getElementById('filePreview');
        const uploadStatus = document.getElementById('uploadStatus');
        const fileInput = document.getElementById('loan_document');
        
        // Clean up
        if (fileUrl) {
            URL.revokeObjectURL(fileUrl);
            fileUrl = null;
        }
        
        currentFile = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        uploadStatus.classList.add('hidden');
        
        // Disable submit button until new file is uploaded
        document.getElementById('submitBtn').disabled = true;
    }
    
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transition-all duration-300 flex items-center ${
            type === 'error' ? 'bg-red-500 text-white' : 
            type === 'success' ? 'bg-green-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-3"></i>
            <span>${message}</span>
        `;
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
    
    // Form validation
    document.getElementById('loanApplicationForm').addEventListener('submit', function(e) {
        const memberId = document.getElementById('member_id').value;
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const period = document.getElementById('period_months').value;
        const purpose = document.getElementById('purpose').value.trim();
        
        if (!memberId) {
            e.preventDefault();
            showToast('Please select a member', 'error');
            return false;
        }
        
        if (amount < 1000) {
            e.preventDefault();
            showToast('Loan amount must be at least KES 1,000', 'error');
            return false;
        }
        
        if (!period || period < 1 || period > 60) {
            e.preventDefault();
            showToast('Please enter a valid repayment period (1-60 months)', 'error');
            return false;
        }
        
        if (!purpose) {
            e.preventDefault();
            showToast('Please enter the loan purpose', 'error');
            return false;
        }
        
        if (!currentFile) {
            e.preventDefault();
            showToast('Please upload the loan application form document', 'error');
            return false;
        }
        
        // Show loading on submit button
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        submitBtn.disabled = true;
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
        
        // Initially disable submit button until file is uploaded
        document.getElementById('submitBtn').disabled = true;
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/loan-assist.blade.php ENDPATH**/ ?>