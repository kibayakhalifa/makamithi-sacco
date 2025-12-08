@extends('components.dashboard-layout')

@section('title', 'Loan Assistance')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Loan Application Assistance</h1>
                <p class="text-gray-500 mt-1">
                    Help members who need assistance with their loan applications
                </p>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
        <div class="flex items-start">
            <div class="text-2xl mr-4">📋</div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">How to Assist Members</h3>
                <ol class="list-decimal pl-5 text-gray-700 space-y-1">
                    <li>Select the member who needs assistance from the list below</li>
                    <li>Fill in the loan application details on their behalf</li>
                    <li>Use the real-time calculator to ensure they qualify (1.5× savings rule)</li>
                    <li>Explain the terms (5% fixed interest) to the member</li>
                    <li>Submit the application which will go to Chairman for approval</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Member Selection -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Select Member to Assist</h2>
            <p class="text-gray-500 text-sm mt-1">Choose a member who needs help with their loan application</p>
        </div>

        <div class="relative mb-6">
            <input type="text" id="memberSearch" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                   placeholder="Search by name, employee number, or department...">
            <div class="absolute right-3 top-3 text-gray-400">
                🔍
            </div>
        </div>

        <!-- Member List -->
        <div class="border rounded-lg divide-y max-h-96 overflow-y-auto" id="memberList">
            <!-- Dummy data will be populated by JavaScript -->
        </div>
    </div>

    <!-- Loan Application Form (Initially Hidden) -->
    <div id="loanForm" class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hidden">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Loan Application for <span id="selectedMemberName">-</span></h2>
            <p class="text-gray-500 text-sm mt-1">Member Number: <span id="selectedMemberNumber" class="font-mono">-</span></p>
        </div>

        <!-- Selected Member Info -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-900" id="displayMemberName">-</p>
                    <p class="text-sm text-gray-500" id="displayMemberNumber">-</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-900" id="displayMemberSavings">KES 0.00</p>
                    <p class="text-xs text-gray-500">Available Savings</p>
                    <p class="text-xs text-blue-600 mt-1">
                        Maximum Eligibility: <span id="maxEligibilityDisplay">KES 0.00</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Loan Calculator -->
        <div id="loanApplicationForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Loan Amount (KES) *</label>
                        <input type="number" id="loanAmount" step="0.01"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                               placeholder="Enter amount"
                               oninput="calculateLoan()">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repayment Period *</label>
                        <select id="loanPeriod" onchange="calculateLoan()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <option value="12">12 months (1 year)</option>
                            <option value="24" selected>24 months (2 years)</option>
                            <option value="36">36 months (3 years)</option>
                            <option value="48">48 months (4 years)</option>
                            <option value="60">60 months (5 years)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purpose of Loan *</label>
                        <textarea id="loanPurpose" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                  placeholder="Brief description of what the loan will be used for..."></textarea>
                        <p class="text-xs text-gray-400 mt-1">e.g., School fees, home renovation, medical expenses</p>
                    </div>
                </div>

                <!-- Calculation Results -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-4">Loan Summary</h5>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Loan Amount:</span>
                            <span class="font-medium" id="displayLoanAmount">KES 0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">5% Fixed Interest:</span>
                            <span class="font-medium" id="interestAmount">KES 0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Repayable:</span>
                            <span class="font-medium" id="totalRepayable">KES 0.00</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Monthly Payment:</span>
                                <span class="text-lg font-semibold text-gray-900" id="monthlyPayment">KES 0.00</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1" id="paymentDuration">For 0 months</p>
                        </div>
                    </div>

                    <!-- Eligibility Status -->
                    <div id="eligibilityStatus" class="mt-4 p-3 rounded-lg hidden">
                        <div class="flex items-center">
                            <span class="mr-2" id="statusIcon">⚠️</span>
                            <span class="text-sm" id="statusMessage"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between pt-6 border-t mt-6">
                <button type="button" onclick="resetSelection()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    ← Select Different Member
                </button>
                <button type="button" onclick="submitLoanApplication()"
                        class="px-6 py-3 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition flex items-center">
                    <span class="mr-2">📤</span>
                    Submit Application
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Success Toast -->
<div id="successToast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50">
    Loan application submitted successfully! Sent to Chairman for approval.
</div>

<script>
    // Dummy data for members (same as in members view)
    const dummyMembers = [
        {
            id: 1,
            employee_number: 'EMP001',
            name: 'John Doe',
            email: 'john@makamithi.com',
            department: 'Finance',
            position: 'Senior Accountant',
            phone: '0712 345 678',
            status: 'approved',
            savings: 150000,
            date_joined: '2023-01-15'
        },
        {
            id: 2,
            employee_number: 'EMP002',
            name: 'Jane Smith',
            email: 'jane@makamithi.com',
            department: 'Human Resources',
            position: 'HR Manager',
            phone: '0712 345 679',
            status: 'approved',
            savings: 120000,
            date_joined: '2023-02-20'
        },
        {
            id: 3,
            employee_number: 'EMP003',
            name: 'Robert Johnson',
            email: 'robert@makamithi.com',
            department: 'Operations',
            position: 'Operations Manager',
            phone: '0712 345 680',
            status: 'pending',
            savings: 200000,
            date_joined: '2023-03-10'
        },
        {
            id: 4,
            employee_number: 'EMP004',
            name: 'Mary Wambui',
            email: 'mary@makamithi.com',
            department: 'IT',
            position: 'Software Developer',
            phone: '0712 345 681',
            status: 'approved',
            savings: 180000,
            date_joined: '2023-04-05'
        },
        {
            id: 5,
            employee_number: 'EMP005',
            name: 'Peter Kamau',
            email: 'peter@makamithi.com',
            department: 'Sales',
            position: 'Sales Executive',
            phone: '0712 345 682',
            status: 'approved',
            savings: 95000,
            date_joined: '2023-05-12'
        },
        {
            id: 6,
            employee_number: 'EMP006',
            name: 'Sarah Mwangi',
            email: 'sarah@makamithi.com',
            department: 'Marketing',
            position: 'Marketing Officer',
            phone: '0712 345 683',
            status: 'pending',
            savings: 110000,
            date_joined: '2023-06-18'
        }
    ];

    // Global variables
    let selectedMember = null;

    // Render member list
    function renderMemberList(members = dummyMembers) {
        const container = document.getElementById('memberList');
        container.innerHTML = '';
        
        members.forEach(member => {
            const memberDiv = document.createElement('div');
            memberDiv.className = 'p-4 hover:bg-gray-50 cursor-pointer member-item';
            memberDiv.id = `member-${member.id}`;
            memberDiv.onclick = () => selectMember(member.id, member.name, member.employee_number, member.savings);
            
            const maxLoan = member.savings * 1.5;
            
            memberDiv.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900">${member.name}</p>
                        <p class="text-sm text-gray-500">${member.employee_number} • ${member.department}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">KES ${member.savings.toLocaleString('en-US', {minimumFractionDigits: 2})}</p>
                        <p class="text-xs text-gray-500">Total Savings</p>
                        <p class="text-xs text-blue-600 mt-1">
                            Max Loan: KES ${maxLoan.toLocaleString('en-US', {minimumFractionDigits: 2})}
                        </p>
                    </div>
                </div>
            `;
            container.appendChild(memberDiv);
        });
    }

    // Member Selection
    function selectMember(id, name, number, savings) {
        // Remove previous selection
        document.querySelectorAll('.member-item').forEach(item => {
            item.classList.remove('bg-gray-100', 'border-l-4', 'border-gray-900');
        });
        
        // Add selection to clicked item
        const selectedItem = document.getElementById(`member-${id}`);
        selectedItem.classList.add('bg-gray-100', 'border-l-4', 'border-gray-900');
        
        // Store selected member data
        selectedMember = {
            id: id,
            name: name,
            number: number,
            savings: parseFloat(savings)
        };
        
        // Update form
        document.getElementById('selectedMemberName').textContent = name;
        document.getElementById('selectedMemberNumber').textContent = number;
        document.getElementById('displayMemberName').textContent = name;
        document.getElementById('displayMemberNumber').textContent = number;
        document.getElementById('displayMemberSavings').textContent = 
            'KES ' + savings.toLocaleString('en-US', {minimumFractionDigits: 2});
        
        // Calculate max eligibility (1.5x savings)
        const maxEligible = savings * 1.5;
        document.getElementById('maxEligibilityDisplay').textContent = 
            'KES ' + maxEligible.toLocaleString('en-US', {minimumFractionDigits: 2});
        
        // Show loan form
        document.getElementById('loanForm').classList.remove('hidden');
        
        // Scroll to form
        document.getElementById('loanForm').scrollIntoView({ behavior: 'smooth' });
        
        // Trigger initial calculation
        calculateLoan();
    }

    // Reset selection
    function resetSelection() {
        selectedMember = null;
        document.getElementById('loanForm').classList.add('hidden');
        document.querySelectorAll('.member-item').forEach(item => {
            item.classList.remove('bg-gray-100', 'border-l-4', 'border-gray-900');
        });
        
        // Reset form
        document.getElementById('loanAmount').value = '';
        document.getElementById('loanPurpose').value = '';
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Search functionality
    document.getElementById('memberSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = dummyMembers.filter(member => 
            member.name.toLowerCase().includes(searchTerm) ||
            member.employee_number.toLowerCase().includes(searchTerm) ||
            member.department.toLowerCase().includes(searchTerm)
        );
        renderMemberList(filtered);
    });

    // Loan Calculation
    function calculateLoan() {
        if (!selectedMember) return;
        
        const amount = parseFloat(document.getElementById('loanAmount').value) || 0;
        const period = parseInt(document.getElementById('loanPeriod').value);
        const savings = selectedMember.savings;
        const maxEligible = savings * 1.5;
        
        // Calculate 5% fixed interest
        const interest = amount * 0.05;
        const totalRepayable = amount + interest;
        const monthlyPayment = period > 0 ? totalRepayable / period : 0;
        
        // Update display
        document.getElementById('displayLoanAmount').textContent = 
            'KES ' + amount.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById('interestAmount').textContent = 
            'KES ' + interest.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById('totalRepayable').textContent = 
            'KES ' + totalRepayable.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById('monthlyPayment').textContent = 
            'KES ' + monthlyPayment.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById('paymentDuration').textContent = 
            `For ${period} months (${(period/12).toFixed(1)} years)`;
        
        // Update eligibility status
        const statusEl = document.getElementById('eligibilityStatus');
        const statusIcon = document.getElementById('statusIcon');
        const statusMessage = document.getElementById('statusMessage');
        
        if (amount > maxEligible) {
            statusEl.className = 'mt-4 p-3 rounded-lg bg-red-100 border border-red-200';
            statusIcon.textContent = '❌';
            statusMessage.textContent = `Amount exceeds maximum eligibility of KES ${maxEligible.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            statusEl.classList.remove('hidden');
        } else if (amount <= 0) {
            statusEl.classList.add('hidden');
        } else {
            statusEl.className = 'mt-4 p-3 rounded-lg bg-green-100 border border-green-200';
            statusIcon.textContent = '✅';
            statusMessage.textContent = 'Member qualifies for this loan amount';
            statusEl.classList.remove('hidden');
        }
    }

    // Submit loan application
    function submitLoanApplication() {
        if (!selectedMember) {
            alert('Please select a member first');
            return;
        }
        
        const amount = parseFloat(document.getElementById('loanAmount').value) || 0;
        const purpose = document.getElementById('loanPurpose').value;
        const period = parseInt(document.getElementById('loanPeriod').value);
        const savings = selectedMember.savings;
        const maxEligible = savings * 1.5;
        
        if (amount <= 0) {
            alert('Please enter a valid loan amount');
            return;
        }
        
        if (amount > maxEligible) {
            alert('Loan amount exceeds maximum eligibility of KES ' + maxEligible.toLocaleString());
            return;
        }
        
        if (!purpose.trim()) {
            alert('Please enter the purpose of the loan');
            return;
        }
        
        // Calculate loan details
        const interest = amount * 0.05;
        const totalRepayable = amount + interest;
        const monthlyPayment = totalRepayable / period;
        
        // Confirmation dialog
        const confirmed = confirm(
            `Submit loan application for ${selectedMember.name}?\n\n` +
            `Loan Amount: KES ${amount.toLocaleString('en-US', {minimumFractionDigits: 2})}\n` +
            `Interest (5%): KES ${interest.toLocaleString('en-US', {minimumFractionDigits: 2})}\n` +
            `Total Repayable: KES ${totalRepayable.toLocaleString('en-US', {minimumFractionDigits: 2})}\n` +
            `Monthly Payment: KES ${monthlyPayment.toLocaleString('en-US', {minimumFractionDigits: 2})}\n` +
            `Period: ${period} months\n` +
            `Purpose: ${purpose}\n\n` +
            `This will be sent to the Chairman for approval.`
        );
        
        if (confirmed) {
            // Show success toast
            const toast = document.getElementById('successToast');
            toast.classList.remove('hidden');
            
            // Reset form
            resetSelection();
            
            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
            
            // Log the application (for demo purposes)
            console.log('Loan Application Submitted:', {
                member: selectedMember.name,
                employee_number: selectedMember.number,
                amount: amount,
                period: period,
                purpose: purpose,
                monthly_payment: monthlyPayment,
                timestamp: new Date().toISOString()
            });
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        renderMemberList();
    });
</script>

<style>
    .member-item:hover {
        background-color: #f9fafb;
    }
    
    .member-item.bg-gray-100 {
        background-color: #f3f4f6;
    }
</style>
@endsection