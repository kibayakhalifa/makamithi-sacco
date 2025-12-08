<!-- resources/views/components/loan-modal.blade.php -->
<div id="loanModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-50 rounded-xl shadow-lg w-full max-w-xl p-6 relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Loan Details</h2>
        <p class="text-gray-600">Applicant: <span id="modalName"></span></p>
        <p class="text-gray-600">Loan Amount: <span id="modalAmount"></span></p>
        <p class="text-gray-600">Duration: <span id="modalMonths"></span> months</p>
        <p class="text-gray-600">Savings: <span id="modalSavings"></span></p>
        <div class="mt-6 flex justify-end space-x-3">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Close</button>
            <button class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Approve</button>
            <button class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Reject</button>
        </div>
    </div>
</div>

<script>
function viewLoan(id){
    // Populate modal dynamically (replace with real data)
    document.getElementById('modalName').innerText = 'John Doe';
    document.getElementById('modalAmount').innerText = 'KES 150,000';
    document.getElementById('modalMonths').innerText = '24';
    document.getElementById('modalSavings').innerText = 'KES 100,000';
    document.getElementById('loanModal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('loanModal').classList.add('hidden');
}
</script>
