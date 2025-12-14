

<?php $__env->startSection('title', 'Member Management - Chairman'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Member Management</h1>
                    <p class="text-gray-500 mt-1">
                        Hello <?php echo e(auth()->user()->name); ?> — review and approve member applications, manage SACCO membership.
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-xl font-semibold text-gray-800"><?php echo e(now()->format('d M Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Members -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Members</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900"><?php echo e($stats['total_members']); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stats['pending_members'] > 0): ?>
                            <p class="text-xs text-yellow-600 mt-1"><?php echo e($stats['pending_members']); ?> pending approval</p>
                        <?php else: ?>
                            <p class="text-xs text-green-600 mt-1">All members approved</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-3xl text-gray-300">👥</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Active: <?php echo e($stats['active_members'] ?? 0); ?></span>
                        <span>Pending: <?php echo e($stats['pending_members']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Pending Approval</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900"><?php echo e($stats['pending_members']); ?></p>
                        <p class="text-xs text-yellow-600 mt-1">Require your review</p>
                    </div>
                    <div class="text-3xl text-yellow-300">⏳</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>New: <?php echo e($pendingMembersList->where('days_pending', 0)->count()); ?></span>
                        <?php
                            $oldestDays = $pendingMembersList->max('days_pending') ?? 0;
                            $oldestDate = \Carbon\Carbon::now()->subDays($oldestDays);
                        ?>

                        <span>Oldest: <?php echo e($oldestDate->diffForHumans()); ?></span>


                    </div>
                </div>
            </div>

            <!-- Active Loans -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Active Loans</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900"><?php echo e($stats['active_loans']); ?></p>
                        <p class="text-xs text-blue-600 mt-1">KES <?php echo e(number_format($stats['total_loan_amount'])); ?> total</p>
                    </div>
                    <div class="text-3xl text-blue-300">📝</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Defaulting: <?php echo e($stats['defaulted_loans']); ?></span>
                        <span>Amount: KES <?php echo e(number_format($stats['total_loan_amount'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Total Savings -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Savings</p>
                        <p class="text-3xl font-semibold mt-2 text-gray-900">KES
                            <?php echo e(number_format($stats['total_savings'])); ?>

                        </p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stats['monthly_savings_increase'] > 0): ?>
                            <p class="text-xs text-green-600 mt-1">+KES <?php echo e(number_format($stats['monthly_savings_increase'])); ?>

                                this month</p>
                        <?php else: ?>
                            <p class="text-xs text-gray-500 mt-1">No increase this month</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-3xl text-green-300">💰</div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Members: <?php echo e($stats['active_members'] ?? 0); ?></span>
                        <span>Avg: KES
                            <?php echo e($stats['total_members'] > 0 ? number_format($stats['total_savings'] / $stats['total_members']) : 0); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Pending Member Approvals</h2>
                    <p class="text-gray-500 text-sm mt-1">New members submitted by Secretary awaiting your approval</p>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingMembersList->count() > 0): ?>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        <?php echo e($pendingMembersList->count()); ?> pending review
                    </span>
                <?php else: ?>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        ✅ All approved
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingMembersList->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Employee #
                                </th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Name &
                                    Details</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Employment
                                    Info</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Submitted
                                </th>
                                <th class="px-6 py-3 text-left text-gray-600 font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pendingMembersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300"><?php echo e($index + 1); ?></td>
                                    <td class="px-6 py-4 font-mono text-gray-900 border-r border-gray-300">
                                        <?php echo e($member['employee_number']); ?>

                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <div class="font-medium text-gray-900"><?php echo e($member['name']); ?></div>
                                        <div class="text-gray-500 text-xs"><?php echo e($member['email']); ?></div>
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <?php echo e($member['days_pending'] == 0 ? 'Today' : $member['days_pending'] . ' days ago'); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <div class="text-gray-700"><?php echo e($member['department']); ?></div>
                                        <div class="text-gray-500 text-xs"><?php echo e($member['position']); ?></div>
                                        <div class="text-gray-500 text-xs mt-1">KES <?php echo e(number_format($member['salary'])); ?>/month
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 border-r border-gray-300">
                                        <div class="text-gray-700"><?php echo e($member['submitted_date']->format('d M Y')); ?></div>
                                        <div class="text-gray-500 text-xs">By <?php echo e($member['submitted_by']); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="relative inline-block group">
                                            <button
                                                class="px-4 py-2 bg-gray-600 text-white rounded-lg text-xs font-medium hover:bg-gray-700 transition flex items-center gap-1">
                                                Actions ▼
                                            </button>
                                            <div
                                                class="hidden group-hover:block absolute right-0 mt-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                                <button onclick="viewMemberDetails(<?php echo e($member['id']); ?>)"
                                                    class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50 border-b border-gray-200 text-sm">👁
                                                    Review</button>
                                                <button onclick="approveMember(<?php echo e($member['id']); ?>)"
                                                    class="w-full text-left px-4 py-2 text-green-600 hover:bg-green-50 border-b border-gray-200 text-sm">✓
                                                    Approve</button>
                                                <button onclick="rejectMember(<?php echo e($member['id']); ?>)"
                                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm">✗
                                                    Reject</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-lg font-medium text-gray-900">No pending approvals</h3>
                    <p class="text-gray-500 mt-1">All members have been approved</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- All Members Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">All SACCO Members</h2>
                    <p class="text-gray-500 text-sm mt-1">Complete list of Makamithi SACCO members</p>
                </div>
                <div class="flex space-x-3">
                    <input type="text" placeholder="Search members..."
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="searchMembers">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="filterDepartment">
                        <option value="">All Departments</option>
                        <?php
                            $departments = $allMembers->pluck('department')->unique()->filter()->sort();
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept); ?>"><?php echo e($dept); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse" id="membersTable">
                    <thead>
                        <tr class="bg-gray-50 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">No.</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Member #
                            </th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Name</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Department
                            </th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Savings
                            </th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Loan
                                Eligibility</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold border-r border-gray-300">Status</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="membersTableBody">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-4 font-mono text-gray-900 border-r border-gray-300">
                                    <?php echo e($member['employee_number']); ?>

                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900"><?php echo e($member['name']); ?></div>
                                    <div class="text-gray-500 text-xs"><?php echo e($member['email']); ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                    <?php echo e($member['department']); ?>

                                    <div class="text-gray-500 text-xs"><?php echo e($member['position']); ?></div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900">KES <?php echo e(number_format($member['savings'])); ?></div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900">KES <?php echo e(number_format($member['loan_eligibility'])); ?>

                                    </div>
                                    <div class="text-gray-500 text-xs">1.5× savings rule</div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member['status'] === 'active'): ?>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✅
                                            Active</span>
                                    <?php elseif($member['status'] === 'pending'): ?>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳
                                            Pending</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">❌
                                            Inactive</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member['loan_status'] === 'default'): ?>
                                        <div class="mt-1"><span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">⚠️
                                                Defaulting</span></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative inline-block group">
                                        <button
                                            class="px-4 py-2 bg-gray-600 text-white rounded-lg text-xs font-medium hover:bg-gray-700 transition flex items-center gap-1">
                                            Actions ▼
                                        </button>
                                        <div
                                            class="hidden group-hover:block absolute right-0 mt-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                            <button onclick="viewMemberDetails(<?php echo e($member['id']); ?>)"
                                                class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50 border-b border-gray-200 text-sm">👁
                                                View</button>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($member['status'] === 'pending'): ?>
                                                <button onclick="approveMember(<?php echo e($member['id']); ?>)"
                                                    class="w-full text-left px-4 py-2 text-green-600 hover:bg-green-50 border-b border-gray-200 text-sm">✓
                                                    Approve</button>
                                                <button onclick="rejectMember(<?php echo e($member['id']); ?>)"
                                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm">✗
                                                    Reject</button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                <p class="text-sm text-gray-500" id="paginationInfo">Showing <?php echo e($allMembers->count()); ?> of
                    <?php echo e($allMembers->count()); ?> members
                </p>
                <div class="flex space-x-2">
                    <!-- Simple pagination for now -->
                    <span class="text-sm text-gray-500">All members loaded</span>
                </div>
            </div>
        </div>

        <!-- Member Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Department Distribution -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Members by Department</h3>
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departmentDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700"><?php echo e($dept['name']); ?></span>
                                <span class="font-medium text-gray-900"><?php echo e($dept['count']); ?> members
                                    (<?php echo e($dept['percentage']); ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($dept['percentage']); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Status Overview -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Member Status Overview</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-green-600 mb-2"><?php echo e($statusOverview['active_members']); ?>

                        </div>
                        <p class="text-gray-700">Active Members</p>
                        <p class="text-xs text-gray-500 mt-1">Can access all SACCO services</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-yellow-600 mb-2"><?php echo e($statusOverview['pending_approval']); ?>

                        </div>
                        <p class="text-gray-700">Pending Approval</p>
                        <p class="text-xs text-gray-500 mt-1">Awaiting your review</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-red-600 mb-2"><?php echo e($statusOverview['loan_defaulters']); ?></div>
                        <p class="text-gray-700">Loan Defaulters</p>
                        <p class="text-xs text-gray-500 mt-1">Behind on payments</p>
                    </div>
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="text-3xl font-semibold text-blue-600 mb-2"><?php echo e($statusOverview['active_loans']); ?></div>
                        <p class="text-gray-700">Active Loans</p>
                        <p class="text-xs text-gray-500 mt-1">Total KES <?php echo e(number_format($stats['total_loan_amount'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Member Details Modal -->
    <div id="memberDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Member Details</h3>
                    <button onclick="closeMemberDetails()" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
                <p class="text-gray-500 text-sm mt-1" id="modalMemberNumber"></p>
            </div>

            <div class="p-6">
                <div id="memberDetailsContent">
                    <!-- Content will be loaded by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Confirmation Modal -->
    <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md">
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="approvalTitle">Approve Member</h3>
                <p class="text-gray-500 text-sm mt-1" id="approvalMessage"></p>
            </div>

            <div class="p-6 space-y-4">
                <div id="rejectionReason" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                    <textarea id="rejectionComments" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                        placeholder="Provide reason for rejection..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeApprovalModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button onclick="confirmApproval()" id="confirmApproveBtn"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition hidden">
                        ✅ Approve Member
                    </button>
                    <button onclick="confirmRejection()" id="confirmRejectBtn"
                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition hidden">
                        ❌ Reject Member
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // State variables
        let currentMemberId = null;
        let approvalAction = ''; // 'approve' or 'reject'
        let allMembers = <?php echo json_encode($allMembers, 15, 512) ?>;

        // Search and filter functionality
        function filterMembers() {
            const searchTerm = document.getElementById('searchMembers').value.toLowerCase();
            const department = document.getElementById('filterDepartment').value;
            const status = document.getElementById('filterStatus').value;

            let filtered = allMembers.filter(member => {
                const matchesSearch =
                    member.name.toLowerCase().includes(searchTerm) ||
                    member.employee_number.toLowerCase().includes(searchTerm) ||
                    member.email.toLowerCase().includes(searchTerm) ||
                    member.department.toLowerCase().includes(searchTerm);

                const matchesDept = department ? member.department === department : true;
                const matchesStatus = status ? member.status === status : true;

                return matchesSearch && matchesDept && matchesStatus;
            });

            renderMembers(filtered);
        }

        // Render members table
        function renderMembers(filteredMembers) {
            const tbody = document.getElementById('membersTableBody');
            tbody.innerHTML = '';

            filteredMembers.forEach((member, index) => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-300 hover:bg-gray-50 transition';
                row.innerHTML = `
                                <td class="px-6 py-4 text-gray-900 font-medium border-r border-gray-300">${index + 1}</td>
                                <td class="px-6 py-4 font-mono text-gray-900 border-r border-gray-300">${member.employee_number}</td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900">${member.name}</div>
                                    <div class="text-gray-500 text-xs">${member.email}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 border-r border-gray-300">
                                    ${member.department}
                                    <div class="text-gray-500 text-xs">${member.position}</div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900">KES ${member.savings.toLocaleString()}</div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    <div class="font-medium text-gray-900">KES ${member.loan_eligibility.toLocaleString()}</div>
                                    <div class="text-gray-500 text-xs">1.5× savings rule</div>
                                </td>
                                <td class="px-6 py-4 border-r border-gray-300">
                                    ${member.status === 'active' ?
                        '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✅ Active</span>' :
                        member.status === 'pending' ?
                            '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳ Pending</span>' :
                            '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">❌ Inactive</span>'}
                                    ${member.loan_status === 'default' ?
                        '<div class="mt-1"><span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">⚠️ Defaulting</span></div>' : ''}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative inline-block group">
                                        <button class="px-4 py-2 bg-gray-600 text-white rounded-lg text-xs font-medium hover:bg-gray-700 transition flex items-center gap-1">
                                            Actions ▼
                                        </button>
                                        <div class="hidden group-hover:block absolute right-0 mt-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                            <button onclick="viewMemberDetails(${member.id})" class="w-full text-left px-4 py-2 text-blue-600 hover:bg-blue-50 border-b border-gray-200 text-sm">👁 View</button>
                                            ${member.status === 'pending' ? `
                                                <button onclick="approveMember(${member.id})" class="w-full text-left px-4 py-2 text-green-600 hover:bg-green-50 border-b border-gray-200 text-sm">✓ Approve</button>
                                                <button onclick="rejectMember(${member.id})" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm">✗ Reject</button>
                                            ` : ''}
                                        </div>
                                    </div>
                                </td>
                            `;
                tbody.appendChild(row);
            });

            // Update pagination info
            document.getElementById('paginationInfo').textContent =
                `Showing ${filteredMembers.length} of ${allMembers.length} members`;
        }

        // View member details
        async function viewMemberDetails(id) {
            try {
                const response = await fetch(`/chairman/member/${id}/details`);
                const data = await response.json();

                if (data.success) {
                    const member = data.member;
                    currentMemberId = id;

                    document.getElementById('modalMemberNumber').textContent = `Member: ${member.employee_number}`;

                    const detailsHtml = `
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Personal Information -->
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                                            <div class="space-y-3">
                                                <div>
                                                    <p class="text-sm text-gray-500">Full Name</p>
                                                    <p class="font-medium text-gray-900">${member.name}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Email Address</p>
                                                    <p class="font-medium text-gray-900">${member.email}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Phone Number</p>
                                                    <p class="font-medium text-gray-900">${member.phone}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Date Joined</p>
                                                    <p class="font-medium text-gray-900">${member.date_joined}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Employment Details -->
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Details</h4>
                                            <div class="space-y-3">
                                                <div>
                                                    <p class="text-sm text-gray-500">Department</p>
                                                    <p class="font-medium text-gray-900">${member.department}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Position</p>
                                                    <p class="font-medium text-gray-900">${member.position}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Employee Number</p>
                                                    <p class="font-medium text-gray-900">${member.employee_number}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Member Status</p>
                                                    <p class="font-medium ${member.status === 'active' ? 'text-green-600' : member.status === 'pending' ? 'text-yellow-600' : 'text-red-600'}">
                                                        ${member.status.charAt(0).toUpperCase() + member.status.slice(1)}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Financial Summary -->
                                        <div class="md:col-span-2">
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">Financial Summary</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div class="bg-gray-50 p-4 rounded-lg">
                                                    <p class="text-sm text-gray-500">Total Savings</p>
                                                    <p class="text-2xl font-semibold text-gray-900">KES ${member.savings.toLocaleString()}</p>
                                                </div>
                                                <div class="bg-gray-50 p-4 rounded-lg">
                                                    <p class="text-sm text-gray-500">Loan Eligibility</p>
                                                    <p class="text-2xl font-semibold text-gray-900">KES ${member.loan_eligibility.toLocaleString()}</p>
                                                    <p class="text-xs text-gray-500 mt-1">Based on 1.5× savings rule</p>
                                                </div>
                                                <div class="bg-gray-50 p-4 rounded-lg">
                                                    <p class="text-sm text-gray-500">Loan Status</p>
                                                    <p class="text-xl font-semibold ${member.loan_status === 'active' ? 'text-blue-600' : member.loan_status === 'default' ? 'text-red-600' : 'text-gray-600'}">
                                                        ${member.loan_status_text}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        ${member.status === 'pending' ? `
                                        <div class="md:col-span-2 pt-6 border-t">
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">Approval Actions</h4>
                                            <div class="flex space-x-4">
                                                <button onclick="approveMember(${member.id})"
                                                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                                                    <span class="mr-2">✅</span>
                                                    Approve Member
                                                </button>
                                                <button onclick="rejectMember(${member.id})"
                                                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                                                    <span class="mr-2">❌</span>
                                                    Reject Member
                                                </button>
                                            </div>
                                        </div>
                                        ` : ''}
                                    </div>
                                `;

                    document.getElementById('memberDetailsContent').innerHTML = detailsHtml;
                    document.getElementById('memberDetailsModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading member details:', error);
                alert('Error loading member details');
            }
        }

        function closeMemberDetails() {
            document.getElementById('memberDetailsModal').classList.add('hidden');
            currentMemberId = null;
        }

        // Approve member
        function approveMember(id) {
            const member = allMembers.find(m => m.id === id);
            if (!member) return;

            currentMemberId = id;
            approvalAction = 'approve';

            document.getElementById('approvalTitle').textContent = 'Approve Member';
            document.getElementById('approvalMessage').textContent = `Approve ${member.name} (${member.employee_number}) as a SACCO member?`;
            document.getElementById('rejectionReason').classList.add('hidden');
            document.getElementById('confirmApproveBtn').classList.remove('hidden');
            document.getElementById('confirmRejectBtn').classList.add('hidden');

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        // Reject member
        function rejectMember(id) {
            const member = allMembers.find(m => m.id === id);
            if (!member) return;

            currentMemberId = id;
            approvalAction = 'reject';

            document.getElementById('approvalTitle').textContent = 'Reject Member';
            document.getElementById('approvalMessage').textContent = `Reject ${member.name}'s membership application?`;
            document.getElementById('rejectionReason').classList.remove('hidden');
            document.getElementById('confirmApproveBtn').classList.add('hidden');
            document.getElementById('confirmRejectBtn').classList.remove('hidden');

            document.getElementById('approvalModal').classList.remove('hidden');
        }

        function closeApprovalModal() {
            document.getElementById('approvalModal').classList.add('hidden');
            currentMemberId = null;
            approvalAction = '';
            document.getElementById('rejectionComments').value = '';
        }

        async function confirmApproval() {
            if (!currentMemberId) return;

            try {
                const formData = new FormData();
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('action', 'approve');
                formData.append('notes', '');

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // Reload the page to show updated data
                    window.location.reload();
                } else {
                    alert('Failed to approve member');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error approving member');
            }
        }

        async function confirmRejection() {
            if (!currentMemberId) return;

            const reason = document.getElementById('rejectionComments').value;
            if (!reason.trim()) {
                alert('Please provide a reason for rejection');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('action', 'reject');
                formData.append('rejection_reason', reason);

                const response = await fetch(`/chairman/member/${currentMemberId}/approve`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // Reload the page to show updated data
                    window.location.reload();
                } else {
                    alert('Failed to reject member');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error rejecting member');
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            // Add event listeners for search and filter
            document.getElementById('searchMembers').addEventListener('input', filterMembers);
            document.getElementById('filterDepartment').addEventListener('change', filterMembers);
            document.getElementById('filterStatus').addEventListener('change', filterMembers);

            // Close modals when clicking outside
            window.onclick = function (event) {
                const detailsModal = document.getElementById('memberDetailsModal');
                const approvalModal = document.getElementById('approvalModal');

                if (event.target == detailsModal) {
                    closeMemberDetails();
                }
                if (event.target == approvalModal) {
                    closeApprovalModal();
                }
            }
        });
    </script>

    <style>
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .progress-bar {
            height: 0.5rem;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/chairman/members.blade.php ENDPATH**/ ?>