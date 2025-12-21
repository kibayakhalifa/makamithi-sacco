<?php $__env->startSection('title', 'Loan Details - ' . $loan->loan_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-4">

        <!-- Header - Compact -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl font-bold text-gray-900 truncate"><?php echo e($loan->loan_number); ?></h1>
                        <div class="flex items-center gap-1 flex-wrap">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->isFirstLoan()): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">First Loan</span>
                            <?php elseif($loan->isSecondLoan()): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Second Loan</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'pending'): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">⏳ Pending</span>
                            <?php elseif($loan->status === 'approved'): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">✅ Approved</span>
                            <?php elseif($loan->status === 'rejected'): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">❌ Rejected</span>
                            <?php elseif($loan->status === 'disbursed' || $loan->status === 'active'): ?>
                                <span class="px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">💸 Active</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <p class="text-gray-600 text-xs truncate mt-0.5"><?php echo e($loan->purpose ?? 'General Purpose'); ?></p>
                </div>
                <a href="<?php echo e(route('member.loans.index')); ?>"
                    class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition text-xs mt-2 sm:mt-0">
                    ← Back to Loans
                </a>
            </div>
        </div>

        <!-- Loan Relationships - Compact -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->isSecondLoan() && $loan->parentLoan): ?>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-center gap-2">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-sm">🔗</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-blue-900 mb-0.5">Connected to First Loan</h3>
                        <p class="text-xs text-blue-700 truncate">
                            Linked to: 
                            <a href="<?php echo e(route('member.loans.show', $loan->parentLoan->id)); ?>" 
                               class="font-medium underline hover:text-blue-900">
                                <?php echo e($loan->parentLoan->loan_number); ?>

                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if($loan->isFirstLoan() && $loan->secondLoan): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <div class="flex items-center gap-2">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-green-600 text-sm">🔗</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-green-900 mb-0.5">Has Second Loan</h3>
                        <p class="text-xs text-green-700 truncate">
                            Second loan: 
                            <a href="<?php echo e(route('member.loans.show', $loan->secondLoan->id)); ?>" 
                               class="font-medium underline hover:text-green-900">
                                <?php echo e($loan->secondLoan->loan_number); ?>

                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">

            <!-- Main Content -->
            <div class="xl:col-span-3 space-y-4">

                <!-- Loan Stats - More Compact -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-white border border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-0.5">Amount</p>
                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->amount, 0)); ?></p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-0.5">Interest</p>
                        <p class="font-bold text-gray-900"><?php echo e($loan->interest_rate); ?>%</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-0.5">Total Payable</p>
                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->total_repayable, 0)); ?></p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-0.5">Monthly</p>
                        <p class="font-bold text-gray-900">KES <?php echo e(number_format($loan->monthly_payment, 0)); ?></p>
                    </div>
                </div>

                <!-- Progress & Payment - Compact -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-semibold text-gray-900">Payment Progress</h2>
                        <div class="text-right text-xs">
                            <p class="text-gray-600">Paid: <span class="font-bold">KES <?php echo e(number_format($loan->amount_paid, 0)); ?></span></p>
                            <p class="text-gray-600">Balance: <span class="font-bold">KES <?php echo e(number_format($remainingBalance, 0)); ?></span></p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span><?php echo e(number_format($percentagePaid, 1)); ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="<?php echo e($loan->isFirstLoan() ? 'bg-blue-600' : 'bg-green-600'); ?> h-1.5 rounded-full" style="width: <?php echo e(min($percentagePaid, 100)); ?>%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-0.5">
                            <span><?php echo e($loan->months_paid); ?> months paid</span>
                            <span><?php echo e($loan->months_remaining); ?> months remaining</span>
                        </div>
                    </div>

                    <!-- Next Payment -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->status === 'active' || $loan->status === 'disbursed'): ?>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-0">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-blue-800 font-medium mb-0.5">Next Payment Due</p>
                                <div class="flex items-baseline gap-1">
                                    <p class="text-lg font-bold text-blue-900">KES <?php echo e(number_format($loan->monthly_payment, 0)); ?></p>
                                    <p class="text-xs text-blue-600">Due <?php echo e($loan->next_payment_date?->format('d M') ?? 'Not set'); ?></p>
                                </div>
                            </div>
                            <a href="<?php echo e(route('member.payments.create', $loan->id)); ?>"
                                class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-xs">
                                Make Payment
                            </a>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- IMPROVED PAYMENT SCHEDULE TABLE -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900">Payment Schedule</h2>
                                <p class="text-xs text-gray-500 mt-0.5"><?php echo e($loan->period_months); ?> monthly installments</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-xs text-gray-600 hidden sm:block">
                                    Remaining: <span class="font-semibold">KES <?php echo e(number_format($loan->remaining_balance, 0)); ?></span>
                                </div>
                                <a href="<?php echo e(route('member.loans.print-schedule', $loan)); ?>" target="_blank"
                                class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-xs flex items-center gap-1">
                                    <span>🖨️</span>
                                    <span class="hidden sm:inline">Print</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Excel-like Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="border-b border-gray-200">
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs border-r border-gray-200">#</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs border-r border-gray-200">Due Date</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs border-r border-gray-200">Amount Due</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs border-r border-gray-200">Status</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs border-r border-gray-200">Remaining Balance</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 text-xs">Payment Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $remainingBalance = $loan->remaining_balance;
                                    $monthsPaid = $loan->months_paid;
                                    $totalMonths = $loan->period_months;
                                    $futurePayment = $totalMonths - $monthsPaid > 0 ? ceil($remainingBalance / ($totalMonths - $monthsPaid)) : 0;
                                    $startDate = $loan->disbursed_date ? \Carbon\Carbon::parse($loan->disbursed_date) : now();
                                ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $totalMonths; $i++): ?>
                                    <?php
                                        $dueDate = $startDate->copy()->addMonths($i);
                                        $isPaid = $i <= $monthsPaid;
                                        $isNext = $i == $monthsPaid + 1;
                                        $isPastDue = !$isPaid && $dueDate < now();
                                        $isFuture = $i > $monthsPaid + 1;
                                        
                                        $amount = $isPaid ? $loan->monthly_payment : $futurePayment;
                                        $balanceAfter = $isPaid ? $remainingBalance + $amount : max(0, $remainingBalance - $amount);
                                        
                                        $rowClass = '';
                                        if ($isPaid) $rowClass = 'bg-green-50';
                                        elseif ($isNext) $rowClass = 'bg-blue-50 font-semibold';
                                        elseif ($isPastDue) $rowClass = 'bg-red-50';
                                    ?>
                                    
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 <?php echo e($rowClass); ?>">
                                        <!-- Installment Number -->
                                        <td class="px-3 py-2 border-r border-gray-100 text-gray-700 <?php echo e($isNext ? 'text-blue-700' : ''); ?>">
                                            <?php echo e($i); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isNext): ?>
                                            <span class="inline-block ml-1 text-blue-600 text-xs">▶</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        
                                        <!-- Due Date -->
                                        <td class="px-3 py-2 border-r border-gray-100 whitespace-nowrap">
                                            <div class="<?php echo e($isNext ? 'font-medium' : ''); ?>"><?php echo e($dueDate->format('d M Y')); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isNext): ?>
                                            <div class="text-xs text-blue-600 mt-0.5">Next Payment</div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        
                                        <!-- Amount Due (Clean Column) -->
                                        <td class="px-3 py-2 border-r border-gray-100 font-medium">
                                            <div class="<?php echo e($isPaid ? 'text-green-700' : 'text-gray-900'); ?>">
                                                KES <?php echo e(number_format($amount, 0)); ?>

                                            </div>
                                        </td>
                                        
                                        <!-- Status (Clean Column) -->
                                        <td class="px-3 py-2 border-r border-gray-100">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPaid): ?>
                                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">Paid</span>
                                            <?php elseif($isNext): ?>
                                            <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded-full">Due Now</span>
                                            <?php elseif($isPastDue): ?>
                                            <span class="px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">Overdue</span>
                                            <?php else: ?>
                                            <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">Pending</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        
                                        <!-- Remaining Balance -->
                                        <td class="px-3 py-2 border-r border-gray-100 font-mono text-gray-800">
                                            KES <?php echo e(number_format($balanceAfter, 0)); ?>

                                        </td>
                                        
                                        <!-- Payment Type (New Column) -->
                                        <td class="px-3 py-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPaid): ?>
                                            <span class="text-xs text-green-600">Regular</span>
                                            <?php elseif($amount != $loan->monthly_payment && !$isPaid): ?>
                                            <div class="flex flex-col">
                                                <span class="text-xs text-red-600">Adjusted</span>
                                                <span class="text-xs text-gray-500">(Original: KES <?php echo e(number_format($loan->monthly_payment, 0)); ?>)</span>
                                            </div>
                                            <?php else: ?>
                                            <span class="text-xs text-gray-500">Scheduled</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                        $remainingBalance = $balanceAfter;
                                    ?>
                                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Summary -->
                    <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-gray-600">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2.5 h-2.5 bg-green-100 border border-green-300 rounded-sm"></div>
                                    <span>Paid</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2.5 h-2.5 bg-blue-100 border border-blue-300 rounded-sm"></div>
                                    <span>Current</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2.5 h-2.5 bg-gray-100 border border-gray-300 rounded-sm"></div>
                                    <span>Pending</span>
                                </div>
                            </div>
                            <div class="font-medium">
                                Total Paid: <span class="text-green-700">KES <?php echo e(number_format($loan->amount_paid, 0)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - More Compact -->
            <div class="space-y-4">
                <!-- Timeline - Compact -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wide mb-3">Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-5 w-5 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 text-xs">✓</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-900">Applied</p>
                                <p class="text-xs text-gray-500"><?php echo e($loan->applied_date->format('d M Y')); ?></p>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->approved_date): ?>
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 text-xs">✓</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-900">Approved</p>
                                <p class="text-xs text-gray-500"><?php echo e($loan->approved_date->format('d M Y')); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->approver): ?>
                                <p class="text-xs text-gray-600 mt-0.5">By <?php echo e($loan->approver->name); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->disbursed_date): ?>
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-5 w-5 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-purple-600 text-xs">$</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-900">Disbursed</p>
                                <p class="text-xs text-gray-500"><?php echo e($loan->disbursed_date->format('d M Y')); ?></p>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->expected_completion_date): ?>
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="h-5 w-5 rounded-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-600 text-xs">⏱</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-900">Expected Completion</p>
                                <p class="text-xs text-gray-500"><?php echo e($loan->expected_completion_date->format('d M Y')); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->expected_completion_date > now()): ?>
                                <p class="text-xs text-blue-600 font-medium mt-0.5">
                                    <?php echo e(max(0, $loan->expected_completion_date->diffInDays(now()))); ?> days left
                                </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Key Stats - Compact -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 space-y-3">
                    <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wide">Key Stats</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Loan Period</span>
                            <span class="text-xs font-medium text-gray-900"><?php echo e($loan->period_months); ?> months</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Payments Made</span>
                            <span class="text-xs font-medium text-gray-900"><?php echo e($loan->months_paid); ?>/<?php echo e($loan->period_months); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-600">Completion</span>
                            <span class="text-xs font-medium text-gray-900"><?php echo e(number_format(($loan->months_paid/$loan->period_months)*100, 0)); ?>%</span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->support_document): ?>
                        <div class="pt-2 border-t border-gray-100">
                            <a href="<?php echo e(asset('storage/' . $loan->support_document)); ?>" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800">
                                <span>📄</span>
                                View Support Document
                            </a>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions - Always Visible but Conditional Content -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wide mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($loan->status === 'active' || $loan->status === 'disbursed') && $remainingBalance > 0): ?>
                        <a href="<?php echo e(route('member.payments.create', $loan->id)); ?>"
                            class="block w-full text-center px-3 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition text-xs">
                            Make Payment
                        </a>
                        <button onclick="showEarlyRepaymentModal()"
                            class="block w-full text-center px-3 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-xs">
                            Early Full Repayment
                        </button>
                        <?php elseif($loan->status === 'pending'): ?>
                        <p class="text-xs text-gray-600 text-center py-2">Awaiting approval</p>
                        <?php elseif($loan->status === 'rejected'): ?>
                        <div class="text-center py-2">
                            <p class="text-xs text-red-600 mb-2"><?php echo e($loan->rejection_reason ?? 'Loan was rejected'); ?></p>
                            <a href="<?php echo e(route('member.loans.apply')); ?>"
                                class="text-xs text-blue-600 hover:text-blue-800 underline">
                                Apply for new loan
                            </a>
                        </div>
                        <?php elseif($remainingBalance <= 0): ?>
                        <p class="text-xs text-green-600 text-center py-2">✓ Loan Fully Paid</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Second Loan Eligibility - Compact -->
                <?php if($loan->isFirstLoan() && $loan->status === 'active' && !$loan->secondLoan): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="text-xs font-semibold text-yellow-900 mb-2">Second Loan Eligibility</h4>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-yellow-800 mb-1">
                            <span>Progress:</span>
                            <span><?php echo e(number_format($loan->percentage_paid, 1)); ?>/50%</span>
                        </div>
                        <div class="w-full bg-yellow-200 rounded-full h-1.5">
                            <div class="bg-yellow-600 h-1.5 rounded-full" style="width: <?php echo e(min($loan->percentage_paid, 50) * 2); ?>%"></div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loan->percentage_paid >= 50): ?>
                    <a href="<?php echo e(route('member.loans.apply')); ?>"
                        class="block w-full text-center px-3 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition text-xs">
                        Apply for Second Loan
                    </a>
                    <?php else: ?>
                    <p class="text-xs text-yellow-700 text-center">
                        Need <?php echo e(number_format(50 - $loan->percentage_paid, 1)); ?>% more to qualify
                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Early Repayment Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($loan->status === 'active' || $loan->status === 'disbursed') && $remainingBalance > 0): ?>
    <div id="earlyRepaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full">
            <div class="p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Early Full Repayment</h3>
                <p class="text-xs text-gray-600 mb-3">
                    Pay off entire remaining balance of 
                    <strong class="text-gray-900">KES <?php echo e(number_format($remainingBalance, 0)); ?></strong>
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded p-2 mb-3">
                    <p class="text-xs text-yellow-800">
                        <strong>Note:</strong> May affect future loan eligibility.
                    </p>
                </div>
                <form id="earlyRepaymentForm" action="<?php echo e(route('member.loans.early-repayment', $loan->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="hideEarlyRepaymentModal()"
                            class="px-3 py-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-xs">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-3 py-1.5 rounded bg-blue-600 text-white font-medium hover:bg-blue-700 transition text-xs">
                            Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showEarlyRepaymentModal() {
            document.getElementById('earlyRepaymentModal').classList.remove('hidden');
        }
        function hideEarlyRepaymentModal() {
            document.getElementById('earlyRepaymentModal').classList.add('hidden');
        }
        document.getElementById('earlyRepaymentModal').addEventListener('click', function(e) {
            if (e.target === this) hideEarlyRepaymentModal();
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.dashboard-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/show.blade.php ENDPATH**/ ?>