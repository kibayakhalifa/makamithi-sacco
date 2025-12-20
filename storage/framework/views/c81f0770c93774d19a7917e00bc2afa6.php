

<?php $__env->startSection('title', 'Register New Member'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                <i class="fas fa-user-plus mr-2 text-green-600"></i> Register New Member
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Register a new employee into the SACCO system
            </p>
        </div>
        <a href="<?php echo e(route('secretary.members')); ?>" 
           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <form action="<?php echo e(route('secretary.members.store')); ?>" method="POST" class="space-y-4 p-4 sm:p-6">
            <?php echo csrf_field(); ?>
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-user-circle mr-2 text-green-600"></i> Personal Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="employee_number" class="block text-xs font-medium text-gray-700 mb-1">
                            Employee Number *
                        </label>
                        <input type="text" name="employee_number" id="employee_number" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['employee_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('employee_number')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['employee_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="national_id" class="block text-xs font-medium text-gray-700 mb-1">
                            National ID *
                        </label>
                        <input type="text" name="national_id" id="national_id" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['national_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('national_id')); ?>" required maxlength="8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['national_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('name')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email Address *
                        </label>
                        <input type="email" name="email" id="email" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('email')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-medium text-gray-700 mb-1">
                            Phone Number *
                        </label>
                        <input type="text" name="phone" id="phone" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('phone')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-xs font-medium text-gray-700 mb-1">
                            Date of Birth *
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('date_of_birth')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-briefcase mr-2 text-green-600"></i> Employment Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="department" class="block text-xs font-medium text-gray-700 mb-1">
                            Department *
                        </label>
                        <select name="department" id="department" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 bg-white appearance-none <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               required>
                            <option value="">Select Department</option>
                            <option value="Finance" <?php echo e(old('department') == 'Finance' ? 'selected' : ''); ?>>Finance</option>
                            <option value="Human Resources" <?php echo e(old('department') == 'Human Resources' ? 'selected' : ''); ?>>Human Resources</option>
                            <option value="Information Technology" <?php echo e(old('department') == 'Information Technology' ? 'selected' : ''); ?>>Information Technology</option>
                            <option value="Operations" <?php echo e(old('department') == 'Operations' ? 'selected' : ''); ?>>Operations</option>
                            <option value="Marketing" <?php echo e(old('department') == 'Marketing' ? 'selected' : ''); ?>>Marketing</option>
                            <option value="Sales" <?php echo e(old('department') == 'Sales' ? 'selected' : ''); ?>>Sales</option>
                            <option value="Customer Service" <?php echo e(old('department') == 'Customer Service' ? 'selected' : ''); ?>>Customer Service</option>
                            <option value="Procurement" <?php echo e(old('department') == 'Procurement' ? 'selected' : ''); ?>>Procurement</option>
                            <option value="Administration" <?php echo e(old('department') == 'Administration' ? 'selected' : ''); ?>>Administration</option>
                            <option value="Research & Development" <?php echo e(old('department') == 'Research & Development' ? 'selected' : ''); ?>>Research & Development</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="position" class="block text-xs font-medium text-gray-700 mb-1">
                            Position *
                        </label>
                        <input type="text" name="position" id="position" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('position')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="employment_date" class="block text-xs font-medium text-gray-700 mb-1">
                            Employment Date *
                        </label>
                        <input type="date" name="employment_date" id="employment_date" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['employment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('employment_date')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['employment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="monthly_salary" class="block text-xs font-medium text-gray-700 mb-1">
                            Monthly Salary (KES) *
                        </label>
                        <input type="number" name="monthly_salary" id="monthly_salary" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['monthly_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('monthly_salary')); ?>" min="0" step="0.01" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['monthly_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- SACCO Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-piggy-bank mr-2 text-green-600"></i> SACCO Information
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="monthly_savings" class="block text-xs font-medium text-gray-700 mb-1">
                            Monthly Savings (KES) *
                        </label>
                        <input type="number" name="monthly_savings" id="monthly_savings" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['monthly_savings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('monthly_savings')); ?>" min="0" step="0.01" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['monthly_savings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="mt-1 text-xs text-gray-500">Deducted from salary monthly</p>
                    </div>

                    <div>
                        <label for="initial_topup" class="block text-xs font-medium text-gray-700 mb-1">
                            Initial Topup (KES)
                        </label>
                        <input type="number" name="initial_topup" id="initial_topup" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['initial_topup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('initial_topup')); ?>" min="0" step="0.01">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['initial_topup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="mt-1 text-xs text-gray-500">Optional initial deposit</p>
                    </div>

                    
                </div>
            </div>

            <!-- Next of Kin Information -->
            <div>
                <h3 class="text-base font-medium text-gray-900 mb-3">
                    <i class="fas fa-users mr-2 text-green-600"></i> Next of Kin (Optional)
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="next_of_kin_name" class="block text-xs font-medium text-gray-700 mb-1">
                            Name
                        </label>
                        <input type="text" name="next_of_kin_name" id="next_of_kin_name" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['next_of_kin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('next_of_kin_name')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['next_of_kin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="next_of_kin_relationship" class="block text-xs font-medium text-gray-700 mb-1">
                            Relationship
                        </label>
                        <select name="next_of_kin_relationship" id="next_of_kin_relationship" 
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 bg-white appearance-none <?php $__errorArgs = ['next_of_kin_relationship'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Select Relationship</option>
                            <option value="Spouse" <?php echo e(old('next_of_kin_relationship') == 'Spouse' ? 'selected' : ''); ?>>Spouse</option>
                            <option value="Parent" <?php echo e(old('next_of_kin_relationship') == 'Parent' ? 'selected' : ''); ?>>Parent</option>
                            <option value="Sibling" <?php echo e(old('next_of_kin_relationship') == 'Sibling' ? 'selected' : ''); ?>>Sibling</option>
                            <option value="Child" <?php echo e(old('next_of_kin_relationship') == 'Child' ? 'selected' : ''); ?>>Child</option>
                            <option value="Other" <?php echo e(old('next_of_kin_relationship') == 'Other' ? 'selected' : ''); ?>>Other</option>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['next_of_kin_relationship'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="next_of_kin_phone" class="block text-xs font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>
                        <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['next_of_kin_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('next_of_kin_phone')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['next_of_kin_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="next_of_kin_id" class="block text-xs font-medium text-gray-700 mb-1">
                            National ID
                        </label>
                        <input type="text" name="next_of_kin_id" id="next_of_kin_id" 
                               class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['next_of_kin_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('next_of_kin_id')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['next_of_kin_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-end space-x-2">
                    <a href="<?php echo e(route('secretary.members')); ?>" 
                       class="px-3 py-2 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-user-plus mr-1"></i> Register Member
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Improved dropdown styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    select:focus {
        outline: none;
        ring: 1px;
        ring-color: #059669;
    }
    
    /* Better focus states */
    input:focus, select:focus {
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
    }
    
    /* Compact form spacing */
    .form-group {
        margin-bottom: 0.75rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Format phone number to Kenyan format
    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 0) {
            // Keep only last 9 digits and prepend with 254
            value = '254' + value.substring(value.length - 9);
        }
        input.value = value;
    }

    // Format national ID (Kenyan format: 8 digits)
    function formatNationalId(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        input.value = value;
    }

    // Auto-calculate loan eligibility
    function calculateLoanEligibility() {
        const monthlySavings = parseFloat(document.getElementById('monthly_savings').value) || 0;
        const loanEligibility = (monthlySavings * 12) * 1.5; // Annual savings × 1.5
        
        // You can display this somewhere if needed
        console.log('Loan Eligibility:', loanEligibility);
    }

    // Add event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone');
        const nokPhoneInput = document.getElementById('next_of_kin_phone');
        const nationalIdInput = document.getElementById('national_id');
        const nokIdInput = document.getElementById('next_of_kin_id');
        const monthlySavingsInput = document.getElementById('monthly_savings');
        
        if (phoneInput) phoneInput.addEventListener('input', () => formatPhoneNumber(phoneInput));
        if (nokPhoneInput) nokPhoneInput.addEventListener('input', () => formatPhoneNumber(nokPhoneInput));
        if (nationalIdInput) nationalIdInput.addEventListener('input', () => formatNationalId(nationalIdInput));
        if (nokIdInput) nokIdInput.addEventListener('input', () => formatNationalId(nokIdInput));
        if (monthlySavingsInput) monthlySavingsInput.addEventListener('input', calculateLoanEligibility);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/secretary/members/create.blade.php ENDPATH**/ ?>