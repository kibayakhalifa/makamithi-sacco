

<?php $__env->startSection('title', 'Members Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">👥</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Members Management</h1>
                        <p class="text-gray-500 text-sm md:text-base">View and manage all SACCO members</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
                    <p class="text-gray-500 text-xs">Total</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo e($stats['total_members']); ?></p>
                </div>
                <div class="bg-white border border-green-200 rounded-lg p-3 text-center">
                    <p class="text-gray-500 text-xs">Active</p>
                    <p class="text-xl font-bold text-green-600"><?php echo e($stats['active_members']); ?></p>
                </div>
                <div class="bg-white border border-yellow-200 rounded-lg p-3 text-center">
                    <p class="text-gray-500 text-xs">Inactive</p>
                    <p class="text-xl font-bold text-yellow-600"><?php echo e($stats['inactive_members']); ?></p>
                </div>
                <div class="bg-white border border-red-200 rounded-lg p-3 text-center">
                    <p class="text-gray-500 text-xs">Suspended</p>
                    <p class="text-xl font-bold text-red-600"><?php echo e($stats['suspended_members']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <form method="GET" action="<?php echo e(route('treasurer.members')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="<?php echo e($search); ?>" 
                           placeholder="Name, Employee No, Email..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="all" <?php echo e($status == 'all' ? 'selected' : ''); ?>>All Status</option>
                        <option value="active" <?php echo e($status == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e($status == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="suspended" <?php echo e($status == 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="all" <?php echo e($department == 'all' ? 'selected' : ''); ?>>All Departments</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept); ?>" <?php echo e($department == $dept ? 'selected' : ''); ?>><?php echo e($dept); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
                
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Filter
                    </button>
                    <a href="<?php echo e(route('treasurer.members')); ?>"
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium text-center">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Members Table -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">All Members</h3>
                    <p class="text-gray-500 text-sm">Showing <?php echo e($members->count()); ?> of <?php echo e($stats['total_members']); ?> members</p>
                </div>
                <div class="text-sm text-gray-600">
                    Total: KES <?php echo e(number_format($stats['total_savings'], 2)); ?> savings • 
                    KES <?php echo e(number_format($stats['total_loans'], 2)); ?> loans
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Monthly Deduction</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $savings = $member->savings;
                            $activeLoans = $member->loans->whereIn('status', ['active', 'disbursed']);
                            $totalActiveLoans = $activeLoans->sum('remaining_balance');
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-blue-700 font-medium text-sm">
                                            <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?php echo e($member->name); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($member->employee_number); ?></p>
                                        <p class="text-gray-500 text-xs"><?php echo e($member->department ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-gray-900 text-sm"><?php echo e($member->email); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($member->phone ?? 'No phone'); ?></p>
                                <p class="text-gray-500 text-xs">
                                    Joined: <?php echo e($member->created_at->format('d M Y')); ?>

                                </p>
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-medium text-green-600">
                                    KES <?php echo e(number_format($savings->available_savings ?? 0, 2)); ?>

                                </p>
                                <div class="text-xs text-gray-500 space-y-1 mt-1">
                                    <p>Total: KES <?php echo e(number_format($savings->total_deposits ?? 0, 2)); ?></p>
                                    <p>Withdrawn: KES <?php echo e(number_format($savings->total_withdrawn ?? 0, 2)); ?></p>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeLoans->count() > 0): ?>
                                    <p class="font-medium text-purple-600">
                                        KES <?php echo e(number_format($totalActiveLoans, 2)); ?>

                                    </p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <p><?php echo e($activeLoans->count()); ?> active loan(s)</p>
                                        <p><?php echo e($member->loans->where('status', 'paid')->count()); ?> paid loan(s)</p>
                                    </div>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm">No active loans</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600 text-sm">KES</span>
                                        <span class="font-medium"><?php echo e(number_format($member->monthly_savings ?? 0, 2)); ?></span>
                                    </div>
                                    <div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->deduction_active): ?>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 border border-red-200">
                                                Inactive
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->sacco_status == 'active'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Active
                                    </span>
                                <?php elseif($member->sacco_status == 'inactive'): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Inactive
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Suspended
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member->status_updated_at): ?>
                                    <p class="text-gray-500 text-xs mt-1">
                                        <?php echo e($member->status_updated_at->format('d M')); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col gap-2">
                                    <a href="<?php echo e(route('treasurer.member.view', $member->id)); ?>"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium text-center">
                                        View Details
                                    </a>
                                    <button onclick="openEditModal(<?php echo e($member->id); ?>, '<?php echo e($member->sacco_status); ?>', <?php echo e($member->monthly_savings ?? 0); ?>, <?php echo e($member->deduction_active ? 'true' : 'false'); ?>)"
                                            class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Edit Settings
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($members->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($members->withQueryString()->links()); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($members->count() == 0): ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-gray-400 text-2xl">👤</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Members Found</h3>
                <p class="text-gray-500 mb-6">Try adjusting your search or filters</p>
                <a href="<?php echo e(route('treasurer.members')); ?>"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    Clear Filters
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Edit Member Settings</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✕
                </button>
            </div>
        </div>
        
        <form id="editForm" class="p-6">
            <input type="hidden" id="memberId">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Status</label>
                    <select id="memberStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Inactive members won't receive deductions</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Savings Amount (KES)</label>
                    <input type="number" id="monthlySavings" step="100" min="0" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                           placeholder="Enter monthly savings amount">
                    <p class="text-gray-500 text-xs mt-1">Fixed amount deducted monthly</p>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="deductionActive" 
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="deductionActive" class="ml-2 block text-sm text-gray-700">
                        Include in payroll deductions
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Change Notes (Optional)</label>
                    <textarea id="changeNotes" rows="2" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Reason for changes..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Edit Member Modal
function openEditModal(memberId, currentStatus, monthlySavings, deductionActive) {
    const modal = document.getElementById('editModal');
    const memberIdInput = document.getElementById('memberId');
    const statusSelect = document.getElementById('memberStatus');
    const savingsInput = document.getElementById('monthlySavings');
    const deductionCheckbox = document.getElementById('deductionActive');
    
    memberIdInput.value = memberId;
    statusSelect.value = currentStatus;
    savingsInput.value = monthlySavings;
    deductionCheckbox.checked = deductionActive;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('editForm').reset();
}

// Update Member Settings
document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const memberId = document.getElementById('memberId').value;
    const status = document.getElementById('memberStatus').value;
    const monthlySavings = document.getElementById('monthlySavings').value;
    const deductionActive = document.getElementById('deductionActive').checked;
    const notes = document.getElementById('changeNotes').value;
    
    try {
        // Update status
        const statusResponse = await fetch(`/treasurer/member/${memberId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                sacco_status: status,
                notes: notes
            })
        });
        
        // Update deduction settings
        const deductionResponse = await fetch(`/treasurer/member/${memberId}/update-deduction`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                monthly_savings: monthlySavings,
                deduction_active: deductionActive,
                notes: notes
            })
        });
        
        const statusData = await statusResponse.json();
        const deductionData = await deductionResponse.json();
        
        if (statusData.success && deductionData.success) {
            alert('✅ Member settings updated successfully');
            closeEditModal();
            location.reload();
        } else {
            alert('❌ Error updating member settings');
        }
        
    } catch (error) {
        alert('❌ Error updating member settings');
        console.error(error);
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editModal');
    if (modal && !modal.classList.contains('hidden') && event.target === modal) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('editModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeEditModal();
        }
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/treasurer/members.blade.php ENDPATH**/ ?>