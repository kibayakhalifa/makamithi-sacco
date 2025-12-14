

<?php $__env->startSection('title', 'Edit Notification'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <a href="<?php echo e(route('communications.show', $communication->id)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2 mb-3">
                    <span>←</span> Back to Notification
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 <?php echo e($communication->type === 'announcement' ? 'bg-green-100' : ($communication->type === 'notice' ? 'bg-blue-100' : 'bg-purple-100')); ?> rounded-xl flex items-center justify-center">
                        <span class="<?php echo e($communication->type === 'announcement' ? 'text-green-600' : ($communication->type === 'notice' ? 'text-blue-600' : 'text-purple-600')); ?> font-bold">
                            <?php echo e($communication->type === 'announcement' ? '📢' : ($communication->type === 'notice' ? '📋' : '📝')); ?>

                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Edit Notification</h1>
                        <p class="text-gray-500 text-sm md:text-base">Update notification details</p>
                    </div>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($communication->type === 'announcement' ? 'bg-green-100 text-green-800 border border-green-200' : ($communication->type === 'notice' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-purple-100 text-purple-800 border border-purple-200')); ?>">
                <?php echo e(ucfirst($communication->type)); ?>

            </span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <form action="<?php echo e(route('communications.update', $communication->id)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" value="<?php echo e(old('title', $communication->title)); ?>" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-gray-400 focus:ring-0 transition"
                    placeholder="Enter notification title">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Body -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                <textarea name="body" rows="5" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-gray-400 focus:ring-0 transition resize-none"
                    placeholder="Type your notification message here..."><?php echo e(old('body', $communication->body)); ?></textarea>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                <select name="type" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:border-gray-400 focus:ring-0 transition">
                    <option value="announcement" <?php echo e(old('type', $communication->type) == 'announcement' ? 'selected' : ''); ?>>📢 Announcement</option>
                    <option value="notice" <?php echo e(old('type', $communication->type) == 'notice' ? 'selected' : ''); ?>>📋 Notice</option>
                    <option value="memo" <?php echo e(old('type', $communication->type) == 'memo' ? 'selected' : ''); ?>>📝 Memo</option>
                    <option value="reminder" <?php echo e(old('type', $communication->type) == 'reminder' ? 'selected' : ''); ?>>⏰ Reminder</option>
                    <option value="update" <?php echo e(old('type', $communication->type) == 'update' ? 'selected' : ''); ?>>🔄 Update</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Audience -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Audience *</label>
                <select name="audience_type" id="audience_type" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:border-gray-400 focus:ring-0 transition">
                    <option value="all" <?php echo e(old('audience_type', $communication->audience_type) == 'all' ? 'selected' : ''); ?>>👥 All Members</option>
                    <option value="committee" <?php echo e(old('audience_type', $communication->audience_type) == 'committee' ? 'selected' : ''); ?>>👨‍⚖️ Committee Members</option>
                    <option value="role" <?php echo e(old('audience_type', $communication->audience_type) == 'role' ? 'selected' : ''); ?>>👤 Specific Role</option>
                    <option value="specific" <?php echo e(old('audience_type', $communication->audience_type) == 'specific' ? 'selected' : ''); ?>>🎯 Specific Users</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['audience_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Role Selector -->
            <div id="roles_selector" class="<?php echo e(old('audience_type', $communication->audience_type) == 'role' ? '' : 'hidden'); ?>">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Roles</label>
                <div class="space-y-2">
                    <?php
                        $allowedRoles = json_decode($communication->allowed_roles ?? '[]', true) ?: [];
                        $oldRoles = old('allowed_roles', $allowedRoles);
                    ?>
                    <div class="flex items-center">
                        <input type="checkbox" name="allowed_roles[]" value="member" id="role_member" 
                            class="mr-3" <?php echo e(in_array('member', $oldRoles) ? 'checked' : ''); ?>>
                        <label for="role_member" class="text-gray-700">👤 Member</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="allowed_roles[]" value="secretary" id="role_secretary" 
                            class="mr-3" <?php echo e(in_array('secretary', $oldRoles) ? 'checked' : ''); ?>>
                        <label for="role_secretary" class="text-gray-700">📝 Secretary</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="allowed_roles[]" value="treasurer" id="role_treasurer" 
                            class="mr-3" <?php echo e(in_array('treasurer', $oldRoles) ? 'checked' : ''); ?>>
                        <label for="role_treasurer" class="text-gray-700">💰 Treasurer</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="allowed_roles[]" value="chairman" id="role_chairman" 
                            class="mr-3" <?php echo e(in_array('chairman', $oldRoles) ? 'checked' : ''); ?>>
                        <label for="role_chairman" class="text-gray-700">👑 Chairman</label>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['allowed_roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- User Selector -->
            <div id="users_selector" class="<?php echo e(old('audience_type', $communication->audience_type) == 'specific' ? '' : 'hidden'); ?>">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Users</label>
                <select name="specific_users[]" multiple
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:border-gray-400 focus:ring-0 transition">
                    <?php
                        $specificUsers = json_decode($communication->specific_users ?? '[]', true) ?: [];
                        $oldUsers = old('specific_users', $specificUsers);
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Models\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, $oldUsers) ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?> (<?php echo e($user->employee_number ?? 'N/A'); ?>) - <?php echo e(ucfirst($user->role)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
                <p class="text-xs text-gray-500 mt-2">Hold Ctrl/Cmd to select multiple users</p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['specific_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('communications.show', $communication->id)); ?>"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <span>💾</span> Update Notification
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview</h3>
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-blue-600">📢</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900" id="previewTitle"><?php echo e($communication->title); ?></p>
                    <p class="text-sm text-gray-500" id="previewType"><?php echo e(ucfirst($communication->type)); ?></p>
                </div>
            </div>
            <p class="text-gray-700" id="previewBody"><?php echo e($communication->body); ?></p>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-500" id="previewAudience">
                    Audience: 
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($communication->audience_type === 'all'): ?>
                        All Members
                    <?php elseif($communication->audience_type === 'committee'): ?>
                        Committee Members
                    <?php elseif($communication->audience_type === 'role'): ?>
                        <?php echo e(implode(', ', $allowedRoles)); ?>

                    <?php else: ?>
                        Specific Users
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        </div>
    </div>

</div>

<script>
    // Audience type toggling
    const audienceSelect = document.getElementById('audience_type');
    const rolesSelector = document.getElementById('roles_selector');
    const usersSelector = document.getElementById('users_selector');

    audienceSelect.addEventListener('change', function() {
        rolesSelector.classList.add('hidden');
        usersSelector.classList.add('hidden');

        if(this.value === 'role') {
            rolesSelector.classList.remove('hidden');
            updatePreview();
        } else if(this.value === 'specific') {
            usersSelector.classList.remove('hidden');
            updatePreview();
        } else {
            updatePreview();
        }
    });

    // Real-time preview updates
    document.querySelectorAll('input[name="title"], textarea[name="body"], select[name="type"], select[name="audience_type"]').forEach(element => {
        element.addEventListener('input', updatePreview);
        element.addEventListener('change', updatePreview);
    });

    // Role checkbox updates
    document.querySelectorAll('input[name="allowed_roles[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updatePreview);
    });

    // User select updates
    document.querySelector('select[name="specific_users[]"]')?.addEventListener('change', updatePreview);

    function updatePreview() {
        // Update title
        const titleInput = document.querySelector('input[name="title"]');
        document.getElementById('previewTitle').textContent = titleInput.value || 'Notification Title';

        // Update message
        const bodyInput = document.querySelector('textarea[name="body"]');
        document.getElementById('previewBody').textContent = bodyInput.value || 'Message will appear here...';

        // Update type
        const typeSelect = document.querySelector('select[name="type"]');
        const typeText = typeSelect.options[typeSelect.selectedIndex].text;
        document.getElementById('previewType').textContent = typeText.replace(/[^a-zA-Z\s]/g, '');

        // Update audience
        const audienceSelect = document.getElementById('audience_type');
        let audienceText = '';
        switch(audienceSelect.value) {
            case 'all':
                audienceText = 'All Members';
                break;
            case 'committee':
                audienceText = 'Committee Members';
                break;
            case 'role':
                const selectedRoles = Array.from(document.querySelectorAll('input[name="allowed_roles[]"]:checked'))
                    .map(cb => cb.nextElementSibling.textContent.trim());
                audienceText = selectedRoles.length > 0 ? selectedRoles.join(', ') : 'Specific Roles';
                break;
            case 'specific':
                const userSelect = document.querySelector('select[name="specific_users[]"]');
                const selectedUsers = userSelect ? Array.from(userSelect.selectedOptions).length : 0;
                audienceText = selectedUsers > 0 ? `${selectedUsers} selected users` : 'Specific Users';
                break;
        }
        document.getElementById('previewAudience').textContent = `Audience: ${audienceText}`;
    }

    // Initialize preview and show/hide selectors based on current selection
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
        
        // Initialize audience selector visibility
        if (audienceSelect.value === 'role') {
            rolesSelector.classList.remove('hidden');
        } else if (audienceSelect.value === 'specific') {
            usersSelector.classList.remove('hidden');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/communications/edit.blade.php ENDPATH**/ ?>