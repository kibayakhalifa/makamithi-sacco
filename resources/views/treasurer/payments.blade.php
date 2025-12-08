@extends('components.dashboard-layout')

@section('title', 'Payment Processing')

@section('content')
<div class="space-y-6 font-sans">
    <!-- Header Banner -->
    <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-gray-200">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Payment Processing</h1>
                <p class="text-gray-500 mt-2">Process loan disbursements, withdrawals, and other payments</p>
            </div>
            <div class="text-center md:text-right mt-4 md:mt-0">
                <p class="text-gray-400 text-sm">Pending Payments</p>
                <p class="text-4xl font-bold text-gray-900">KES 450,000</p>
                <p class="text-gray-400 text-xs mt-1">15 payments to process</p>
            </div>
        </div>
    </div>

    <!-- Payment Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Pending Cheques</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">8</p>
                    <p class="text-gray-600 text-sm mt-1">To be issued</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <span class="text-gray-600 text-xl">🏦</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Bank Transfers</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">5</p>
                    <p class="text-gray-600 text-sm mt-1">Awaiting transfer</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <span class="text-gray-600 text-xl">💳</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Processed Today</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">KES 120,000</p>
                    <p class="text-gray-600 text-sm mt-1">3 payments</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <span class="text-gray-600 text-xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Sacco Balance</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">KES 12.4M</p>
                    <p class="text-gray-600 text-sm mt-1">Available funds</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <span class="text-gray-600 text-xl">💰</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Processing Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto -mb-px">
                <button id="loanDisbursementTab" class="px-6 py-4 font-medium border-b-2 border-gray-900 text-gray-900 whitespace-nowrap">
                    🏦 Loan Disbursements (6)
                </button>
                <button id="withdrawalTab" class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    💰 Savings Withdrawals (4)
                </button>
                
                <button id="expenseTab" class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    💸 Expenses (3)
                </button>
                <button id="completedTab" class="px-6 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    ✅ Completed (24)
                </button>
            </nav>
        </div>

        <!-- Loan Disbursements Content -->
        <div id="loanDisbursementContent" class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Beneficiary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approval Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $disbursements = [
                                ['id' => 1, 'loan' => 'LN-00123', 'amount' => 150000, 'name' => 'John Mule', 'emp' => 'EMP001', 'date' => 'Today', 'method' => 'Cheque', 'status' => 'Ready'],
                                ['id' => 2, 'loan' => 'LN-00124', 'amount' => 200000, 'name' => 'Jane Wanjiru', 'emp' => 'EMP045', 'date' => 'Today', 'method' => 'Bank Transfer', 'status' => 'Ready'],
                                ['id' => 3, 'loan' => 'LN-00125', 'amount' => 75000, 'name' => 'Peter Kamau', 'emp' => 'EMP023', 'date' => 'Yesterday', 'method' => 'Cheque', 'status' => 'Pending'],
                                ['id' => 4, 'loan' => 'LN-00126', 'amount' => 300000, 'name' => 'Mary Njeri', 'emp' => 'EMP067', 'date' => '2 days ago', 'method' => 'Bank Transfer', 'status' => 'Ready'],
                                ['id' => 5, 'loan' => 'LN-00127', 'amount' => 120000, 'name' => 'James Otieno', 'emp' => 'EMP089', 'date' => '2 days ago', 'method' => 'Cheque', 'status' => 'Ready'],
                            ];
                        @endphp
                        
                        @foreach($disbursements as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">KES {{ number_format($payment['amount'], 2) }}</p>
                                <p class="text-gray-500 text-sm">Loan #{{ $payment['loan'] }}</p>
                                <p class="text-gray-500 text-xs">5% fixed interest</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-gray-700 font-medium">
                                            {{ strtoupper(substr($payment['name'], 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $payment['name'] }}</p>
                                        <p class="text-gray-500 text-sm">{{ $payment['emp'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $payment['date'] }}</p>
                                <p class="text-gray-500 text-xs">By Chairman + Committee</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $payment['method'] === 'Cheque' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $payment['method'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $payment['status'] === 'Ready' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $payment['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button onclick="processPayment({{ $payment['id'] }})" 
                                            class="bg-gray-900 hover:bg-gray-800 text-white px-3 py-1.5 rounded text-sm font-medium">
                                        Process
                                    </button>
                                    <button onclick="viewPaymentDetails({{ $payment['id'] }})" 
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1.5 rounded text-sm font-medium">
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-between items-center">
                <p class="text-gray-500 text-sm">Showing 5 of 6 loan disbursements</p>
                <button class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium">
                    Load More
                </button>
            </div>
        </div>

        <!-- Other Tabs Content (Hidden by default) -->
        <div id="withdrawalContent" class="p-6 hidden">
            <div class="text-center py-8">
                <div class="text-4xl mb-4">💰</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Savings Withdrawals</h3>
                <p class="text-gray-500">No pending withdrawal requests at the moment.</p>
            </div>
        </div>

        

        <div id="expenseContent" class="p-6 hidden">
            <div class="text-center py-8">
                <div class="text-4xl mb-4">💸</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Expenses</h3>
                <p class="text-gray-500">No expense approvals pending.</p>
            </div>
        </div>

        <div id="completedContent" class="p-6 hidden">
            <div class="text-center py-8">
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Completed Payments</h3>
                <p class="text-gray-500">View completed payment history.</p>
            </div>
        </div>
    </div>

    

<!-- Processing Confirmation Modal -->
<div id="processingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-green-600 text-2xl">✅</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Payment Processed</h3>
            <p class="text-gray-600 mb-6" id="processingMessage">Payment has been successfully processed.</p>
            <button onclick="closeProcessingModal()" 
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-lg font-medium">
                Close
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for Payment Processing -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = {
        loan: { 
            tab: document.getElementById('loanDisbursementTab'), 
            content: document.getElementById('loanDisbursementContent') 
        },
        withdrawal: { 
            tab: document.getElementById('withdrawalTab'), 
            content: document.getElementById('withdrawalContent') 
        },
        refund: { 
            tab: document.getElementById('refundTab'), 
            content: document.getElementById('refundContent') 
        },
        expense: { 
            tab: document.getElementById('expenseTab'), 
            content: document.getElementById('expenseContent') 
        },
        completed: { 
            tab: document.getElementById('completedTab'), 
            content: document.getElementById('completedContent') 
        }
    };
    
    function activateTab(activeTab) {
        // Deactivate all tabs
        Object.values(tabs).forEach(({tab, content}) => {
            if (tab && content) {
                tab.classList.remove('border-b-2', 'border-gray-900', 'text-gray-900');
                tab.classList.add('text-gray-500');
                content.classList.add('hidden');
            }
        });
        
        // Activate selected tab
        if (tabs[activeTab].tab && tabs[activeTab].content) {
            tabs[activeTab].tab.classList.add('border-b-2', 'border-gray-900', 'text-gray-900');
            tabs[activeTab].tab.classList.remove('text-gray-500');
            tabs[activeTab].content.classList.remove('hidden');
        }
    }
    
    // Add click events to tabs
    Object.entries(tabs).forEach(([key, {tab}]) => {
        if (tab) {
            tab.addEventListener('click', () => activateTab(key));
        }
    });
    
    // Select all checkbox
    const selectAll = document.getElementById('selectAllPayments');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#selectAllPayments)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});

// Modal functions
function viewPaymentDetails(paymentId) {
    const paymentDetails = document.getElementById('paymentDetails');
    
    // Mock payment data
    const paymentData = {
        1: {
            loan: 'LN-00123',
            amount: 150000,
            name: 'John Mule',
            emp: 'EMP001',
            date: 'Today',
            method: 'Cheque',
            status: 'Ready',
            interest: 'KES 7,500 (5% fixed)',
            total: 'KES 157,500',
            monthly: 'KES 6,562.50',
            period: '24 months',
            purpose: 'School Fees',
            account: 'Equity Bank • 123-456-789',
            committee: 'Chairman + Secretary'
        }
    };
    
    const payment = paymentData[paymentId] || paymentData[1];
    
    paymentDetails.innerHTML = `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Payment Information</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="font-bold text-2xl text-gray-900">KES ${payment.amount.toLocaleString()}</p>
                        <p class="text-gray-600">Loan #${payment.loan}</p>
                        <p class="text-gray-600">Method: ${payment.method}</p>
                        <p class="text-gray-600">Status: <span class="font-medium">${payment.status}</span></p>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Beneficiary</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="font-bold text-gray-900">${payment.name}</p>
                        <p class="text-gray-600">${payment.emp} • Finance Department</p>
                        <p class="text-gray-600">Account: ${payment.account}</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Loan Details</p>
                    <p class="text-lg font-bold text-gray-900">${payment.purpose}</p>
                    <p class="text-sm text-gray-600">${payment.period} • ${payment.monthly}/month</p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Approval</p>
                    <p class="text-lg font-bold text-gray-900">${payment.committee}</p>
                    <p class="text-sm text-gray-600">Approved: ${payment.date}</p>
                </div>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Payment Instructions</h4>
                <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                    <p class="text-yellow-800 text-sm">
                        ⚠️ Please ensure:
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Cheque is signed by both signatories</li>
                            <li>Payment voucher is attached</li>
                            <li>Member acknowledgment form is ready</li>
                            <li>Update system records after payment</li>
                        </ul>
                    </p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <button onclick="confirmPayment(${paymentId})" class="flex-1 bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-lg font-medium">
                    ✅ Mark as Processed
                </button>
                <button onclick="printVoucher(${paymentId})" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-medium">
                    🖨️ Print Voucher
                </button>
                <button onclick="closePaymentModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-medium">
                    Cancel
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function closeProcessingModal() {
    document.getElementById('processingModal').classList.add('hidden');
}

function processPayment(paymentId) {
    const paymentType = prompt('Enter payment reference/cheque number:');
    if (paymentType) {
        showProcessingMessage(`Payment #${paymentId} processed successfully. Reference: ${paymentType}`);
        // In real app, would make API call here
    }
}

function confirmPayment(paymentId) {
    if (confirm('Confirm that this payment has been processed?')) {
        showProcessingMessage(`Payment #${paymentId} marked as completed and records updated.`);
        closePaymentModal();
    }
}

function showProcessingMessage(message) {
    document.getElementById('processingMessage').textContent = message;
    document.getElementById('processingModal').classList.remove('hidden');
}

function printVoucher(paymentId) {
    alert(`Printing voucher for payment #${paymentId}...`);
    // In real app, would generate PDF
}

function processBulkCheques() {
    if (confirm('Issue cheques for all selected payments?')) {
        showProcessingMessage('Cheques issued for 4 payments. Total: KES 670,000');
    }
}

function processBulkTransfers() {
    if (confirm('Process bank transfers for all selected payments?')) {
        showProcessingMessage('Bank transfers initiated for 4 payments.');
    }
}

function markAsCompleted() {
    if (confirm('Mark all selected payments as completed?')) {
        showProcessingMessage('4 payments marked as completed.');
    }
}

function exportPayments() {
    alert('Exporting payment data to Excel...');
}

function checkBankBalance() {
    showProcessingMessage('Bank balance refreshed. Current: KES 12,450,000.00');
}

// Close modal when clicking outside
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});

document.getElementById('processingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProcessingModal();
    }
});
</script>
@endsection