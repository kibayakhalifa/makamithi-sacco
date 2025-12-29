@extends('components.dashboard-layout')

@section('title', 'Monthly Deduction System')

@section('content')
<div class="space-y-6">
    <!-- Header with Month Selection and Actions -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-blue-700 font-bold">📋</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">Monthly Deduction System</h1>
                        <p class="text-gray-500 text-sm md:text-base">Generate, review, and commit monthly payroll deductions</p>
                    </div>
                </div>
                
                <!-- Month Selection -->
                <div class="mt-4 flex items-center gap-3">
                    <select id="monthSelect" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
                        @foreach($monthOptions as $option)
                            <option value="{{ $option['value'] }}" 
                                    {{ $selectedMonth == $option['value'] ? 'selected' : '' }}
                                    data-status="{{ $option['status'] }}">
                                {{ $option['label'] }} - {{ ucfirst($option['status']) }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Month Status Badge -->
                    <div id="monthStatus" class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $commitment->status == 'draft' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                           ($commitment->status == 'committed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                           'bg-gray-100 text-gray-800 border border-gray-200') }}">
                        {{ ucfirst($commitment->status) }}
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2">
                @if(!$deductionsExist && $commitment->canCommit())
                    <button onclick="generateDeductions()" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>➕</span> Add Deductions for {{ date('F Y', strtotime($selectedMonth)) }}
                    </button>
                @endif
                
                @if($deductionsExist && $commitment->canCommit())
                    <button onclick="regenerateDeductions()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>🔄</span> Regenerate Deductions
                    </button>
                    
                    <button onclick="commitMonth()" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>🔒</span> Commit Month
                    </button>
                @endif
                
                @if($deductionsExist && $commitment->isCommitted())
                    <button onclick="exportDeductions('savings')" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export Savings
                    </button>
                    
                    <button onclick="exportDeductions('loan')" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export Loans
                    </button>
                    
                    <button onclick="exportDeductions('total')" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                        <span>📥</span> Export All
                    </button>
                @endif
            </div>
        </div>
        
        <!-- Stats -->
        @if($deductionsExist)
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Members</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_members'] }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <span class="text-blue-600 text-xl">👥</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Savings</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['total_savings'], 2) }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <span class="text-green-600 text-xl">💰</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Total Loans</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['total_loans'], 2) }}</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <span class="text-purple-600 text-xl">🏦</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wider font-medium">Grand Total</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['total_amount'], 2) }}</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg">
                        <span class="text-orange-600 text-xl">📊</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Main Content Tabs -->
    @if($deductionsExist)
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex">
                <button onclick="switchTab('savings')" id="savingsTab"
                    class="flex-1 px-4 py-4 font-medium border-b-2 border-green-600 text-green-700 whitespace-nowrap text-center">
                    💰 Savings Summary
                </button>
                <button onclick="switchTab('loans')" id="loansTab"
                    class="flex-1 px-4 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-center border-b-2 border-transparent">
                    🏦 Loan Summary
                </button>
                <button onclick="switchTab('total')" id="totalTab"
                    class="flex-1 px-4 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-center border-b-2 border-transparent">
                    📊 Total Summary
                </button>
                <button onclick="switchTab('monthly')" id="monthlyTab"
                    class="flex-1 px-4 py-4 font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap text-center border-b-2 border-transparent">
                    📅 Monthly Summaries
                </button>
            </nav>
        </div>
        
        <!-- Tab 1: Savings Summary -->
        <div id="savingsContent" class="p-6">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Savings Deductions</h3>
                    <p class="text-gray-500 text-sm">Fixed monthly savings amounts with one-off adjustments</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Total: <span class="font-bold text-green-600">KES {{ number_format($savingsTotal, 2) }}</span></p>
                    <p class="text-gray-500 text-xs">{{ $savingsSummary->count() }} members</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase w-12">#</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member Name</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Employee No.</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Department</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Standard Amount</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjustment</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Final Amount</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            @if($canEdit)
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($savingsSummary as $index => $deduction)
                        <tr class="hover:bg-gray-50 {{ $deduction['is_adjusted'] ? 'bg-yellow-50' : '' }}">
                            <td class="border border-gray-300 px-4 py-3 text-center text-gray-600">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $deduction['member']->name }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="text-gray-600">{{ $deduction['employee_number'] }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="text-gray-600">{{ $deduction['department'] ?? 'N/A' }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-medium text-gray-900">{{ number_format($deduction['savings_amount'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($deduction['savings_adjustment'] != 0)
                                    <div class="text-right">
                                        <p class="font-medium {{ $deduction['savings_adjustment'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $deduction['savings_adjustment'] > 0 ? '+' : '' }}{{ number_format($deduction['savings_adjustment'], 2) }}
                                        </p>
                                        @if($deduction['adjustment_notes'])
                                            <p class="text-gray-500 text-xs mt-1 text-left">{{ $deduction['adjustment_notes'] }}</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-gray-400 text-sm text-center">-</p>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-bold text-gray-900">{{ number_format($deduction['savings_final'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($deduction['is_adjusted'])
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Adjusted
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            @if($canEdit)
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <div class="flex gap-2 justify-center">
                                    <button onclick="editDeduction({{ $deduction['id'] }}, 'savings', {{ $deduction['savings_amount'] }}, {{ $deduction['savings_adjustment'] }})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Edit
                                    </button>
                                    @if($deduction['is_adjusted'])
                                    <button onclick="resetDeduction({{ $deduction['id'] }})"
                                            class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                        Reset
                                    </button>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="border border-gray-300 px-4 py-3 text-right font-medium">Totals:</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-gray-900">
                                {{ number_format($savingsSummary->sum('savings_amount'), 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-gray-900">
                                {{ number_format($savingsSummary->sum('savings_adjustment'), 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-green-700">
                                {{ number_format($savingsTotal, 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $savingsSummary->where('is_adjusted', true)->count() }} Adjusted
                                </span>
                            </td>
                            @if($canEdit)
                            <td class="border border-gray-300 px-4 py-3"></td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Tab 2: Loan Summary -->
        <div id="loansContent" class="p-6 hidden">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Loan Repayment Deductions</h3>
                    <p class="text-gray-500 text-sm">Active loan repayments with adjustments. Members with multiple loans appear multiple times.</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Total: <span class="font-bold text-purple-600">KES {{ number_format($loanTotal, 2) }}</span></p>
                    <p class="text-gray-500 text-xs">{{ $loanEntriesCount ?? $loanSummary->count() }} loan entries</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase w-12">#</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member Name</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Employee No.</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loan Type</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loan Number</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Standard Amount</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjustment</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Final Amount</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            @if($canEdit)
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $counter = 1;
                            $loanEntriesCount = 0;
                        @endphp
                        @foreach($loanSummary as $deduction)
                            @php
                                // Count all active loans for this member
                                $activeLoans = $deduction['active_loans'] ?? collect();
                                $loanCount = count($activeLoans);
                                $loanEntriesCount += $loanCount > 0 ? $loanCount : 1;
                                
                                // Determine if adjustment applies to specific loan or total
                                $hasMultipleLoans = $loanCount > 1;
                                $hasAdjustment = $deduction['loan_adjustment'] != 0;
                                
                                // For members with multiple loans, we need to distribute the adjustment proportionally
                                if ($hasMultipleLoans && $hasAdjustment) {
                                    $totalLoanAmount = $deduction['loan_amount'];
                                    if ($totalLoanAmount > 0) {
                                        $adjustmentPerLoan = [];
                                        foreach ($activeLoans as $loanIndex => $loan) {
                                            $loanPercentage = $loan['monthly_payment'] / $totalLoanAmount;
                                            $adjustmentPerLoan[] = [
                                                'amount' => $deduction['loan_adjustment'] * $loanPercentage,
                                                'percentage' => $loanPercentage * 100
                                            ];
                                        }
                                    }
                                }
                            @endphp
                            
                            @if($loanCount > 0)
                                @foreach($activeLoans as $loanIndex => $loan)
                                <tr class="hover:bg-gray-50 {{ $deduction['is_adjusted'] ? 'bg-yellow-50' : '' }}">
                                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-600">{{ $counter++ }}</td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <p class="font-medium text-gray-900">{{ $deduction['member']->name }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <p class="text-gray-600">{{ $deduction['employee_number'] }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        @php
                                            // Determine loan type based on index or loan data
                                            if (isset($loan['loan_type']) && !empty($loan['loan_type'])) {
                                                $loanType = $loan['loan_type'];
                                            } else {
                                                $loanType = $loanIndex == 0 ? 'First Loan' : 'Second Loan';
                                            }
                                        @endphp
                                        <p class="font-medium {{ $loanType == 'First Loan' ? 'text-blue-600' : 'text-green-600' }}">
                                            {{ $loanType }}
                                        </p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <p class="font-medium text-gray-700">#{{ $loan['loan_number'] }}</p>
                                        @if(isset($loan['purpose']) && !empty($loan['purpose']))
                                            <p class="text-gray-500 text-xs">{{ $loan['purpose'] }}</p>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3 text-right">
                                        <p class="font-medium text-gray-900">{{ number_format($loan['monthly_payment'], 2) }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        @if($deduction['loan_adjustment'] != 0)
                                            <div class="text-right">
                                                @if($hasMultipleLoans)
                                                    @php
                                                        $loanAdjustment = $adjustmentPerLoan[$loanIndex]['amount'] ?? 0;
                                                        $adjustmentPercentage = $adjustmentPerLoan[$loanIndex]['percentage'] ?? 0;
                                                    @endphp
                                                    <p class="font-medium {{ $loanAdjustment > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $loanAdjustment > 0 ? '+' : '' }}{{ number_format($loanAdjustment, 2) }}
                                                    </p>
                                                    <p class="text-gray-500 text-xs mt-1">
                                                        {{ number_format($adjustmentPercentage, 1) }}% of total adjustment
                                                    </p>
                                                @else
                                                    <p class="font-medium {{ $deduction['loan_adjustment'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $deduction['loan_adjustment'] > 0 ? '+' : '' }}{{ number_format($deduction['loan_adjustment'], 2) }}
                                                    </p>
                                                @endif
                                                @if($deduction['adjustment_notes'] && !$hasMultipleLoans)
                                                    <p class="text-gray-500 text-xs mt-1 text-left">{{ $deduction['adjustment_notes'] }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-gray-400 text-sm text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3 text-right">
                                        @if($hasMultipleLoans && $hasAdjustment)
                                            @php
                                                $loanFinal = $loan['monthly_payment'] + ($adjustmentPerLoan[$loanIndex]['amount'] ?? 0);
                                            @endphp
                                            <p class="font-bold text-gray-900">{{ number_format($loanFinal, 2) }}</p>
                                        @elseif(!$hasMultipleLoans)
                                            <p class="font-bold text-gray-900">{{ number_format($deduction['loan_final'], 2) }}</p>
                                        @else
                                            <p class="text-gray-500 text-xs">Part of {{ $loanCount }} loans</p>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        @if($deduction['is_adjusted'])
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Adjusted
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                                Standard
                                            </span>
                                        @endif
                                        @if($hasMultipleLoans)
                                            <p class="text-gray-500 text-xs mt-1">{{ $loanCount }} loans</p>
                                        @endif
                                    </td>
                                    @if($canEdit)
                                    <td class="border border-gray-300 px-4 py-3 text-center">
                                        <div class="flex gap-2 justify-center">
                                            @if(!$hasMultipleLoans || ($hasMultipleLoans && $loanCount == 1))
                                                <button onclick="editDeduction({{ $deduction['id'] }}, 'loan', {{ $deduction['loan_amount'] }}, {{ $deduction['loan_adjustment'] }})"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                    Edit
                                                </button>
                                            @else
                                                <button onclick="editMultipleLoans({{ $deduction['id'] }}, {{ json_encode($activeLoans) }}, {{ $deduction['loan_amount'] }}, {{ $deduction['loan_adjustment'] }})"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                    Edit All
                                                </button>
                                            @endif
                                            @if($deduction['is_adjusted'])
                                                <button onclick="resetDeduction({{ $deduction['id'] }})"
                                                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-medium">
                                                    Reset
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @else
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-3 text-center text-gray-600">{{ $counter++ }}</td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <p class="font-medium text-gray-900">{{ $deduction['member']->name }}</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <p class="text-gray-600">{{ $deduction['employee_number'] }}</p>
                                    </td>
                                    <td colspan="4" class="border border-gray-300 px-4 py-3 text-center">
                                        <p class="text-gray-400 text-sm">No active loans</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3 text-center">
                                        <p class="text-gray-400 text-sm">-</p>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3 text-center">
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                            No Loans
                                        </span>
                                    </td>
                                    @if($canEdit)
                                    <td class="border border-gray-300 px-4 py-3"></td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="5" class="border border-gray-300 px-4 py-3 text-right font-medium">Totals:</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-gray-900">
                                {{ number_format($loanSummary->sum(function($item) {
                                    return collect($item['active_loans'] ?? [])->sum('monthly_payment');
                                }), 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-gray-900">
                                {{ number_format($loanSummary->sum('loan_adjustment'), 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-purple-700">
                                {{ number_format($loanTotal, 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $loanSummary->where('is_adjusted', true)->count() }} Adjusted
                                </span>
                            </td>
                            @if($canEdit)
                            <td class="border border-gray-300 px-4 py-3"></td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Tab 3: Total Summary -->
        <div id="totalContent" class="p-6 hidden">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Combined Deductions Summary</h3>
                    <p class="text-gray-500 text-sm">Total deductions per member (Savings + Loans)</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Grand Total: <span class="font-bold text-blue-600">KES {{ number_format($grandTotal, 2) }}</span></p>
                    <p class="text-gray-500 text-xs">{{ $totalSummary->count() }} members</p>
                </div>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase w-12">#</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Member Name</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Employee No.</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Department</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total Amount</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($totalSummary as $index => $deduction)
                        <tr class="hover:bg-gray-50 {{ $deduction['is_adjusted'] ? 'bg-yellow-50' : '' }}">
                            <td class="border border-gray-300 px-4 py-3 text-center text-gray-600">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $deduction['member']->name }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="text-gray-600">{{ $deduction['employee_number'] }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="text-gray-600">{{ $deduction['department'] ?? 'N/A' }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-medium text-green-600">{{ number_format($deduction['savings_final'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-medium text-purple-600">{{ number_format($deduction['loan_final'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-bold text-gray-900">{{ number_format($deduction['total_amount'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($deduction['is_adjusted'])
                                    <div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Adjusted
                                        </span>
                                        @if($deduction['adjustment_notes'])
                                            <p class="text-gray-500 text-xs mt-1">{{ $deduction['adjustment_notes'] }}</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Standard
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="border border-gray-300 px-4 py-3 text-right font-medium">Totals:</td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-green-700">
                                {{ number_format($savingsTotal, 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-purple-700">
                                {{ number_format($loanTotal, 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-blue-700">
                                {{ number_format($grandTotal, 2) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $totalSummary->where('is_adjusted', true)->count() }} Adjusted
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Tab 4: Monthly Summaries -->
        <div id="monthlyContent" class="p-6 hidden">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Monthly Commitment History</h3>
                <p class="text-gray-500 text-sm">Overview of all months with commitment status</p>
            </div>
            
            <div class="overflow-x-auto border border-gray-300 rounded-lg">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase w-12">#</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Month</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Members</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Savings</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Loans</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Adjusted</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Committed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlySummaries as $index => $summary)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="loadSpecificMonth('{{ $summary['month'] }}')">
                            <td class="border border-gray-300 px-4 py-3 text-center text-gray-600">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $summary['label'] }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($summary['status'] == 'draft')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Draft
                                    </span>
                                @elseif($summary['status'] == 'committed')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Committed
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        Locked
                                    </span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <p class="text-gray-900">{{ $summary['member_count'] }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="text-green-600 font-medium">{{ number_format($summary['total_savings'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="text-purple-600 font-medium">{{ number_format($summary['total_loans'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-right">
                                <p class="font-bold text-gray-900">{{ number_format($summary['total_amount'], 2) }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <p class="text-gray-900">{{ $summary['adjusted_count'] }}</p>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($summary['committed_at'])
                                    <p class="text-gray-900 text-sm">{{ $summary['committed_at'] }}</p>
                                    <p class="text-gray-500 text-xs">by {{ $summary['committed_by'] ?? 'System' }}</p>
                                @else
                                    <p class="text-gray-400 text-sm text-center">-</p>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-blue-600 text-2xl">📋</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Deductions Generated Yet</h3>
        <p class="text-gray-500 mb-6">Generate deductions for {{ date('F Y', strtotime($selectedMonth)) }} to start the review process.</p>
        @if($commitment->canCommit())
        <button onclick="generateDeductions()" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 mx-auto">
            <span>➕</span> Generate Deductions for {{ date('F Y', strtotime($selectedMonth)) }}
        </button>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 max-w-md mx-auto">
            <p class="text-yellow-800 text-sm">This month is already committed or locked. Select a different month to generate deductions.</p>
        </div>
        @endif
    </div>
    @endif
</div>

<!-- Edit Deduction Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Adjust Deduction</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✕
                </button>
            </div>
        </div>
        
        <form id="editForm" class="p-6">
            @csrf
            <input type="hidden" id="deductionId">
            <input type="hidden" id="deductionType">
            <input type="hidden" id="standardAmount">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Standard Amount</label>
                    <p id="standardAmountDisplay" class="text-lg font-bold text-gray-900"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Amount</label>
                    <input type="number" id="adjustmentAmount" step="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                           placeholder="Enter adjustment amount (positive or negative)">
                    <p class="text-gray-500 text-xs mt-1">Positive to increase, negative to decrease</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Final Amount</label>
                    <p id="finalAmountDisplay" class="text-lg font-bold text-green-600"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Notes</label>
                    <textarea id="adjustmentNotes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Reason for adjustment..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    Save Adjustment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Commit Month Modal -->
<div id="commitModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Commit Month</h3>
                <button onclick="closeCommitModal()" class="text-gray-500 hover:text-gray-700 text-lg">
                    ✕
                </button>
            </div>
        </div>
        
        <form id="commitForm" class="p-6">
            @csrf
            <div class="space-y-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="text-yellow-600 mr-2">⚠️</span>
                        <p class="text-yellow-800 text-sm font-medium">Important: This action cannot be undone</p>
                    </div>
                    <p class="text-yellow-600 text-xs mt-2">
                        Once committed, all deductions for {{ date('F Y', strtotime($selectedMonth)) }} will be locked and cannot be edited.
                    </p>
                </div>
                
                <div>
                    <p class="text-gray-700 text-sm mb-2">You are about to commit:</p>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• {{ $stats['total_members'] ?? 0 }} members</li>
                        <li>• {{ number_format($stats['total_savings'] ?? 0, 2) }} in savings deductions</li>
                        <li>• {{ number_format($stats['total_loans'] ?? 0, 2) }} in loan repayments</li>
                        <li>• {{ number_format($stats['total_amount'] ?? 0, 2) }} total amount</li>
                    </ul>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commitment Notes (Optional)</label>
                    <textarea id="commitmentNotes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                              placeholder="Add any notes about this commitment..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeCommitModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium">
                    Confirm & Commit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching
function switchTab(tabName) {
    // Hide all content
    ['savings', 'loans', 'total', 'monthly'].forEach(tab => {
        const content = document.getElementById(tab + 'Content');
        const tabBtn = document.getElementById(tab + 'Tab');
        
        if (content) {
            content.classList.add('hidden');
        }
        
        if (tabBtn) {
            tabBtn.classList.remove(
                'border-green-600', 'text-green-700',
                'border-purple-600', 'text-purple-700',
                'border-blue-600', 'text-blue-700',
                'border-gray-600', 'text-gray-700'
            );
            tabBtn.classList.add('text-gray-500', 'border-transparent');
        }
    });

    // Show selected content
    const selectedContent = document.getElementById(tabName + 'Content');
    const selectedTab = document.getElementById(tabName + 'Tab');

    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    if (selectedTab) {
        selectedTab.classList.remove('text-gray-500', 'border-transparent');
        
        const borderClass = tabName === 'savings' ? 'border-green-600' :
                           tabName === 'loans' ? 'border-purple-600' :
                           tabName === 'total' ? 'border-blue-600' :
                           'border-gray-600';
        
        const textClass = tabName === 'savings' ? 'text-green-700' :
                         tabName === 'loans' ? 'text-purple-700' :
                         tabName === 'total' ? 'text-blue-700' :
                         'text-gray-700';
        
        selectedTab.classList.add(borderClass, textClass);
    }
}

// Load specific month
function loadMonth() {
    const monthSelect = document.getElementById('monthSelect');
    const month = monthSelect.value;
    window.location.href = '/treasurer/savings-deductions?month=' + month;
}

function loadSpecificMonth(month) {
    window.location.href = '/treasurer/savings-deductions?month=' + month;
}

// Generate deductions
async function generateDeductions() {
    const month = document.getElementById('monthSelect').value;
    
    if (!confirm(`Generate deductions for ${month}? This will create draft deductions for all active members.`)) {
        return;
    }
    
    try {
        const response = await fetch('/treasurer/generate-deductions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ month: month })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(`✅ ${data.message}`);
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error generating deductions');
        console.error(error);
    }
}

// Regenerate deductions
async function regenerateDeductions() {
    const month = document.getElementById('monthSelect').value;
    
    if (!confirm(`Regenerate deductions for ${month}? This will overwrite existing draft deductions.`)) {
        return;
    }
    
    try {
        const response = await fetch('/treasurer/regenerate-deductions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ month: month })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(`✅ ${data.message}`);
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error regenerating deductions');
        console.error(error);
    }
}

// Edit deduction modal
function editDeduction(id, type, standardAmount, currentAdjustment) {
    const modal = document.getElementById('editModal');
    const deductionId = document.getElementById('deductionId');
    const deductionType = document.getElementById('deductionType');
    const standardAmountInput = document.getElementById('standardAmount');
    const standardAmountDisplay = document.getElementById('standardAmountDisplay');
    const adjustmentAmount = document.getElementById('adjustmentAmount');
    const adjustmentNotes = document.getElementById('adjustmentNotes');
    
    deductionId.value = id;
    deductionType.value = type;
    standardAmountInput.value = standardAmount;
    standardAmountDisplay.textContent = standardAmount.toLocaleString('en-US', { minimumFractionDigits: 2 });
    adjustmentAmount.value = currentAdjustment || 0;
    adjustmentNotes.value = '';
    
    // Calculate initial final amount
    updateFinalAmountDisplay();
    
    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Function to handle editing multiple loans for a member
function editMultipleLoans(id, activeLoans, totalLoanAmount, currentAdjustment) {
    const modal = document.getElementById('editModal');
    const deductionId = document.getElementById('deductionId');
    const deductionType = document.getElementById('deductionType');
    const standardAmountInput = document.getElementById('standardAmount');
    const standardAmountDisplay = document.getElementById('standardAmountDisplay');
    const adjustmentAmount = document.getElementById('adjustmentAmount');
    const adjustmentNotes = document.getElementById('adjustmentNotes');
    
    deductionId.value = id;
    deductionType.value = 'loan';
    standardAmountInput.value = totalLoanAmount;
    standardAmountDisplay.textContent = totalLoanAmount.toLocaleString('en-US', { minimumFractionDigits: 2 });
    adjustmentAmount.value = currentAdjustment || 0;
    adjustmentNotes.value = '';
    
    // Add note about multiple loans
    const noteElement = document.createElement('div');
    noteElement.className = 'bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-2';
    noteElement.innerHTML = `
        <p class="text-yellow-800 text-sm font-medium">⚠️ Member has ${activeLoans.length} active loans</p>
        <p class="text-yellow-600 text-xs mt-1">Adjustment will be distributed proportionally across all loans</p>
    `;
    
    const standardAmountDiv = standardAmountDisplay.parentNode;
    standardAmountDiv.appendChild(noteElement);
    
    // Calculate initial final amount
    updateFinalAmountDisplay();
    
    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function updateFinalAmountDisplay() {
    const standardAmount = parseFloat(document.getElementById('standardAmount').value);
    const adjustment = parseFloat(document.getElementById('adjustmentAmount').value) || 0;
    const finalAmount = standardAmount + adjustment;
    
    document.getElementById('finalAmountDisplay').textContent = 
        finalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 });
}

// Close edit modal
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    // Reset form
    document.getElementById('editForm').reset();
    document.getElementById('adjustmentNotes').value = '';
    
    // Remove any added notes
    const noteElement = document.querySelector('.bg-yellow-50.border-yellow-200');
    if (noteElement) {
        noteElement.remove();
    }
}

// Save deduction adjustment
document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const deductionId = document.getElementById('deductionId').value;
    const type = document.getElementById('deductionType').value;
    const adjustment = parseFloat(document.getElementById('adjustmentAmount').value) || 0;
    const notes = document.getElementById('adjustmentNotes').value;
    
    try {
        const response = await fetch(`/treasurer/deductions/${deductionId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                type: type,
                adjustment: adjustment,
                notes: notes
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Deduction updated successfully');
            closeEditModal();
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error updating deduction');
        console.error(error);
    }
});

// Reset deduction
async function resetDeduction(id) {
    if (!confirm('Reset this deduction to its original values?')) {
        return;
    }
    
    try {
        const response = await fetch(`/treasurer/deductions/${id}/reset`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Deduction reset successfully');
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error resetting deduction');
        console.error(error);
    }
}

// Commit month modal
function commitMonth() {
    const modal = document.getElementById('commitModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCommitModal() {
    const modal = document.getElementById('commitModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Save commitment
document.getElementById('commitForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const month = document.getElementById('monthSelect').value;
    const notes = document.getElementById('commitmentNotes').value;
    
    try {
        const response = await fetch('/treasurer/commit-month', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                month: month,
                notes: notes
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert('✅ Month committed successfully');
            closeCommitModal();
            location.reload();
        } else {
            alert(`❌ ${data.message}`);
        }
    } catch (error) {
        alert('❌ Error committing month');
        console.error(error);
    }
});

// Export deductions
function exportDeductions(type) {
    const month = document.getElementById('monthSelect').value;
    window.location.href = `/treasurer/export-month-deductions?month=${month}&type=${type}`;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set up adjustment amount listener
    const adjustmentAmount = document.getElementById('adjustmentAmount');
    if (adjustmentAmount) {
        adjustmentAmount.addEventListener('input', updateFinalAmountDisplay);
        adjustmentAmount.addEventListener('change', updateFinalAmountDisplay);
    }
    
    // Initialize first tab
    switchTab('savings');
    
    // Add month select change listener
    const monthSelect = document.getElementById('monthSelect');
    if (monthSelect) {
        monthSelect.addEventListener('change', loadMonth);
    }
    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const editModal = document.getElementById('editModal');
        const commitModal = document.getElementById('commitModal');
        
        if (editModal && !editModal.classList.contains('hidden') && event.target === editModal) {
            closeEditModal();
        }
        
        if (commitModal && !commitModal.classList.contains('hidden') && event.target === commitModal) {
            closeCommitModal();
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const editModal = document.getElementById('editModal');
            const commitModal = document.getElementById('commitModal');
            
            if (editModal && !editModal.classList.contains('hidden')) {
                closeEditModal();
            }
            
            if (commitModal && !commitModal.classList.contains('hidden')) {
                closeCommitModal();
            }
        }
    });
});
</script>
@endsection