<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Schedule - <?php echo e($loan->loan_number); ?> - <?php echo e(auth()->user()->role); ?></title>
    <title>Loan Repayment Schedule - <?php echo e($loan->loan_number); ?></title>
    <style>
        @page {
            margin: 15mm;
            size: A4 portrait;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        
        .header h3 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        
        .loan-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px dashed #ddd;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            font-weight: bold;
            color: #333;
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }
        
        .schedule-table th {
            background-color: #2d3748;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        .schedule-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .schedule-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status-paid {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .status-overdue {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
        }
        
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 40px auto 5px auto;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }
        
        @media print {
            .print-button {
                display: none;
            }
            
            body {
                font-size: 10px;
            }
            
            .header h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Schedule</button>

    <div class="header">
        <h1>LOAN REPAYMENT SCHEDULE</h1>
        <h3><?php echo e(config('app.name', 'SACCO Management System')); ?></h3>
        <p>Generated on: <?php echo e(now()->format('d M Y H:i')); ?></p>
    </div>

    <!-- Loan Information -->
    <div class="loan-info">
        <div class="info-item">
            <span class="info-label">Loan Number:</span>
            <span class="info-value"><?php echo e($loan->loan_number); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Member Name:</span>
            <span class="info-value"><?php echo e($loan->user->name); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Employee No:</span>
            <span class="info-value"><?php echo e($loan->user->employee_number); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Loan Amount:</span>
            <span class="info-value">KES <?php echo e(number_format($loan->amount, 2)); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Interest Rate:</span>
            <span class="info-value"><?php echo e($loan->interest_rate); ?>%</span>
        </div>
        <div class="info-item">
            <span class="info-label">Total Repayable:</span>
            <span class="info-value">KES <?php echo e(number_format($loan->total_repayable, 2)); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Loan Period:</span>
            <span class="info-value"><?php echo e($loan->period_months); ?> months</span>
        </div>
        <div class="info-item">
            <span class="info-label">Monthly Payment:</span>
            <span class="info-value">KES <?php echo e(number_format($loan->monthly_payment, 2)); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Amount Paid:</span>
            <span class="info-value">KES <?php echo e(number_format($loan->amount_paid, 2)); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Remaining Balance:</span>
            <span class="info-value">KES <?php echo e(number_format($loan->remaining_balance, 2)); ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Progress:</span>
            <span class="info-value"><?php echo e(number_format($loan->percentage_paid, 1)); ?>%</span>
        </div>
        <div class="info-item">
            <span class="info-label">Disbursement Date:</span>
            <span class="info-value"><?php echo e($loan->disbursed_date?->format('d M Y') ?? 'N/A'); ?></span>
        </div>
    </div>

    <!-- Payment Schedule Table -->
    <table class="schedule-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Amount Due (KES)</th>
                <th>Status</th>
                <th>Balance After (KES)</th>
                <th>Paid Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // SIMPLE CALCULATION - same as in show page
                $remainingBalance = $loan->remaining_balance;
                $monthsPaid = $loan->months_paid;
                $totalMonths = $loan->period_months;
                
                // What each future payment should be
                $remainingMonths = max(1, $totalMonths - $monthsPaid);
                $futurePayment = $remainingMonths > 0 ? ceil($remainingBalance / $remainingMonths) : 0;
                
                $startDate = $loan->disbursed_date ? \Carbon\Carbon::parse($loan->disbursed_date) : now();
            ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $totalMonths; $i++): ?>
                <?php
                    $dueDate = $startDate->copy()->addMonths($i);
                    $isPaid = $i <= $monthsPaid;
                    $isNext = $i == $monthsPaid + 1;
                    $isPastDue = !$isPaid && $dueDate < now();
                    
                    // Amount for this installment
                    $amount = $isPaid ? $loan->monthly_payment : $futurePayment;
                    
                    // Calculate balance after this payment
                    if ($isPaid) {
                        // Already paid - balance was reduced
                        $balanceAfter = $remainingBalance + $amount; // Add back to show correctly
                    } else {
                        // Future payment - reduce balance
                        $balanceAfter = max(0, $remainingBalance - $amount);
                    }
                    
                    // Status text
                    if ($isPaid) {
                        $status = 'PAID';
                        $statusClass = 'status-paid';
                    } elseif ($isPastDue) {
                        $status = 'OVERDUE';
                        $statusClass = 'status-overdue';
                    } elseif ($isNext) {
                        $status = 'NEXT PAYMENT';
                        $statusClass = 'status-pending';
                    } else {
                        $status = 'PENDING';
                        $statusClass = 'status-pending';
                    }
                ?>
                
                <tr>
                    <td><?php echo e($i); ?></td>
                    <td><?php echo e($dueDate->format('d M Y')); ?></td>
                    <td><strong>KES <?php echo e(number_format($amount, 2)); ?></strong></td>
                    <td><span class="<?php echo e($statusClass); ?>"><?php echo e($status); ?></span></td>
                    <td><strong>KES <?php echo e(number_format($balanceAfter, 2)); ?></strong></td>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPaid): ?>
                            <?php echo e($dueDate->format('d M Y')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
                
                <?php
                    // Update running balance for next row
                    $remainingBalance = $balanceAfter;
                ?>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <!-- Important Notes -->
    <div class="footer">
        <div style="text-align: left; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
            <h4 style="margin: 0 0 10px 0; color: #333;">IMPORTANT NOTES:</h4>
            <ol style="margin: 0; padding-left: 20px;">
                <li>This schedule is subject to change based on early or extra payments.</li>
                <li>Payments should be made by the due date to avoid penalties.</li>
                <li>For any discrepancies, contact the SACCO treasurer immediately.</li>
                <li>Keep this document for your records.</li>
            </ol>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line"></div>
                <p><strong>Member's Signature</strong></p>
                <p>Date: __________________</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p><strong>Treasurer's Signature & Stamp</strong></p>
                <p>Date: __________________</p>
            </div>
        </div>

        <p style="margin-top: 20px; font-size: 9px; color: #666;">
            Document generated by <?php echo e(config('app.name', 'SACCO Management System')); ?> • 
            <?php echo e(config('app.url', 'http://localhost')); ?> • 
            <?php echo e(now()->format('d M Y H:i:s')); ?>

        </p>
    </div>

    <script>
        // Auto-print option
        <?php if(request()->get('autoprint') == '1'): ?>
        window.onload = function() {
            window.print();
        }
        <?php endif; ?>
        
        // Add page breaks for printing if needed
        function addPageBreaks() {
            const rows = document.querySelectorAll('.schedule-table tr');
            let pageHeight = 0;
            const maxPageHeight = 900; // Adjust based on your content
            
            rows.forEach((row, index) => {
                pageHeight += row.offsetHeight;
                if (pageHeight > maxPageHeight && index < rows.length - 1) {
                    row.style.pageBreakAfter = 'always';
                    pageHeight = 0;
                }
            });
        }
        
        window.onload = addPageBreaks;
    </script>
</body>
</html><?php /**PATH C:\Users\ADMIN\Desktop\makamithi-sacco\resources\views/member/loans/print-schedule.blade.php ENDPATH**/ ?>