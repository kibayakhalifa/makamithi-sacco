

<?php $__env->startSection('title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Settings</h1>
            <p class="text-gray-500 mt-1">Manage your account preferences, security, and notifications</p>
        </div>

        <!-- Flash Messages -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-green-700 alert-auto-dismiss">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✓</span>
                    <p><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-red-700 alert-auto-dismiss">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✕</span>
                    <p><?php echo e(session('error')); ?></p>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Profile Settings -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Settings</h2>

            <form action="<?php echo e(route('settings.update-profile')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>"
                            class="w-full px-4 py-2 border <?php echo e($errors->has('name') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
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
                        <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>"
                            class="w-full px-4 py-2 border <?php echo e($errors->has('email') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-900 mb-2">Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number" value="<?php echo e(old('phone_number', auth()->user()->phone_number ?? '')); ?>"
                            class="w-full px-4 py-2 border <?php echo e($errors->has('phone_number') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone_number'];
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
                        <label for="department" class="block text-sm font-medium text-gray-900 mb-2">Department</label>
                        <input type="text" id="department" name="department" value="<?php echo e(auth()->user()->department ?? ''); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            disabled>
                    </div>
                </div>

                <div>
                    <label for="role_display" class="block text-sm font-medium text-gray-900 mb-2">Account Role</label>
                    <input type="text" id="role_display" 
                        value="<?php echo e(ucfirst(auth()->user()->role)); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                        disabled>
                    <p class="text-xs text-gray-500 mt-1">Your role cannot be changed. Contact administrator if needed.</p>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Save Profile
                    </button>
                    <a href="javascript:history.back()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Security Settings</h2>

            <form action="<?php echo e(route('settings.update-password')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-900 mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                        class="w-full px-4 py-2 border <?php echo e($errors->has('current_password') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-900 mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password" 
                            class="w-full px-4 py-2 border <?php echo e($errors->has('new_password') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password'];
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
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">Confirm Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                            class="w-full px-4 py-2 border <?php echo e($errors->has('new_password_confirmation') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                        Update Password
                    </button>
                    <a href="javascript:history.back()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Notification Preferences -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Notification Preferences</h2>

            <form action="<?php echo e(route('settings.update-notifications')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <input type="checkbox" id="email_loan_updates" name="email_loan_updates" value="1" 
                            class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            <?php echo e(auth()->user()->notification_email_loans ? 'checked' : ''); ?>>
                        <div class="ml-4">
                            <label for="email_loan_updates" class="block text-sm font-medium text-gray-900">
                                Email about Loan Updates
                            </label>
                            <p class="text-sm text-gray-500">Receive notifications for loan applications, approvals, and disbursements</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="email_savings_updates" name="email_savings_updates" value="1" 
                            class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            <?php echo e(auth()->user()->notification_email_savings ? 'checked' : ''); ?>>
                        <div class="ml-4">
                            <label for="email_savings_updates" class="block text-sm font-medium text-gray-900">
                                Email about Savings Updates
                            </label>
                            <p class="text-sm text-gray-500">Receive notifications for savings transactions and milestones</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="email_member_updates" name="email_member_updates" value="1" 
                            class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            <?php echo e(auth()->user()->notification_email_members ? 'checked' : ''); ?>>
                        <div class="ml-4">
                            <label for="email_member_updates" class="block text-sm font-medium text-gray-900">
                                Email about Member Updates
                            </label>
                            <p class="text-sm text-gray-500">Receive notifications for new members and approvals (Chairmen & Secretaries)</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="email_reports" name="email_reports" value="1" 
                            class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                            <?php echo e(auth()->user()->notification_email_reports ? 'checked' : ''); ?>>
                        <div class="ml-4">
                            <label for="email_reports" class="block text-sm font-medium text-gray-900">
                                Email about Reports
                            </label>
                            <p class="text-sm text-gray-500">Receive notifications when reports are generated or available</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Save Preferences
                    </button>
                    <a href="javascript:history.back()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Account Actions -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Account Actions</h2>

            <div class="space-y-4">
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="font-medium text-red-900 mb-2">Delete Account</h3>
                    <p class="text-red-700 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    <button type="button" onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                        Delete Account Permanently
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-red-900">Delete Account</h2>
            </div>

            <div class="p-6">
                <p class="text-gray-700 mb-4">
                    Are you absolutely sure you want to delete your account? This action cannot be undone.
                </p>
                <p class="text-red-600 font-medium mb-4">
                    All your data will be permanently deleted from the system.
                </p>

                <form action="<?php echo e(route('settings.delete-account')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 mb-1">
                            Enter your password to confirm:
                        </label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/settings.blade.php ENDPATH**/ ?>