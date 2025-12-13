<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\Loan;
use App\Models\SavingsTransaction;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;
use Carbon\Carbon;

class MemberReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    /**
     * Display reports page
     */
    public function index()
    {
        $user = Auth::user();
        $savings = $user->savings;
        
        // Get available report types
        $reportTypes = [
            [
                'id' => 'savings_statement',
                'name' => 'Savings Account Statement',
                'description' => 'Detailed transaction history for your savings account',
                'icon' => '💰',
                'formats' => ['pdf', 'excel', 'print'],
            ],
            [
                'id' => 'loan_statement',
                'name' => 'Loan Account Statement',
                'description' => 'Complete loan history including payments and balances',
                'icon' => '📄',
                'formats' => ['pdf', 'excel'],
            ],
            [
                'id' => 'account_summary',
                'name' => 'Account Summary',
                'description' => 'Overview of your savings, loans, and eligibility',
                'icon' => '📊',
                'formats' => ['pdf', 'print'],
            ],
            [
                'id' => 'year_end_statement',
                'name' => 'Year-End Statement',
                'description' => 'Annual summary for tax or personal records',
                'icon' => '📅',
                'formats' => ['pdf', 'excel'],
            ],
            [
                'id' => 'transaction_history',
                'name' => 'Transaction History',
                'description' => 'All transactions across your accounts',
                'icon' => '📝',
                'formats' => ['pdf', 'excel', 'csv'],
            ],
        ];
        
        // Get recent generated reports
        $recentReports = $this->getRecentReports($user);
        
        return view('member.reports.index', compact('reportTypes', 'recentReports'));
    }

    /**
     * Generate report
     */
    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => ['required', 'string', 'in:savings_statement,loan_statement,account_summary,year_end_statement,transaction_history'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'format' => ['required', 'string', 'in:pdf,excel,csv,print'],
        ]);
        
        $user = Auth::user();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        // Validate date range (max 2 years)
        if ($startDate->diffInYears($endDate) > 2) {
            return redirect()->back()->with('error', 'Date range cannot exceed 2 years.');
        }
        
        // Generate report based on type
        $reportData = $this->prepareReportData($user, $request->report_type, $startDate, $endDate);
        
        // Generate file
        $fileName = $this->generateReportFile($user, $request->report_type, $reportData, $request->format, $startDate, $endDate);
        
        if ($request->input('format') === 'print') {
            return view('member.reports.print.' . $request->input('report_type'), $reportData);
        }
        
        // Store report record
        $this->storeReportRecord($user, $request->report_type, $fileName, $startDate, $endDate, $request->format);
        
        // Return download
        return response()->download(storage_path('app/reports/' . $fileName))
            ->deleteFileAfterSend(true);
    }

    /**
     * Download previously generated report
     */
    public function download($reportId)
    {
        $user = Auth::user();
        
        // In a real app, you would fetch from a reports table
        // For now, generate on-demand
        // This is a placeholder - implement your report storage logic
        
        return redirect()->back()->with('error', 'Report not found or expired.');
    }

    /**
     * Prepare report data
     */
    private function prepareReportData($user, $reportType, $startDate, $endDate)
    {
        $savings = $user->savings;
        $loans = $user->loans()->get();
        
        $data = [
            'user' => $user,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'generated_at' => now(),
        ];
        
        switch ($reportType) {
            case 'savings_statement':
                $data['savings'] = $savings;
                $data['transactions'] = $savings ? 
                    $savings->transactions()
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc')
                        ->get() : collect();
                $data['opening_balance'] = $this->getOpeningBalance($savings, $startDate);
                $data['closing_balance'] = $savings ? $savings->available_savings : 0;
                break;
                
            case 'loan_statement':
                $data['loans'] = $loans;
                $data['loan_payments'] = LoanPayment::whereIn('loan_id', $loans->pluck('id'))
                    ->whereBetween('paid_at', [$startDate, $endDate])
                    ->orderBy('paid_at', 'desc')
                    ->get();
                $data['total_loan_balance'] = $loans->whereIn('status', ['active', 'disbursed'])->sum('remaining_balance');
                break;
                
            case 'account_summary':
                $data['savings'] = $savings;
                $data['loans'] = $loans;
                $data['active_loans'] = $loans->whereIn('status', ['active', 'disbursed']);
                $data['loan_eligibility'] = $user->loan_eligibility;
                $data['withdrawal_amount'] = $user->withdrawal_amount;
                break;
                
            case 'year_end_statement':
                $year = $startDate->year;
                $data['year'] = $year;
                $data['savings'] = $savings;
                $data['year_start_balance'] = $this->getSavingsBalanceAtDate($savings, Carbon::create($year, 1, 1));
                $data['year_end_balance'] = $savings ? $savings->available_savings : 0;
                $data['total_deposits'] = $savings ? 
                    $savings->transactions()
                        ->whereIn('type', ['payroll_deduction', 'voluntary_deposit', 'interest_credit'])
                        ->whereYear('transaction_date', $year)
                        ->sum('amount') : 0;
                $data['total_interest'] = $savings ? $savings->interest_earned : 0;
                $data['loan_summary'] = $this->getLoanYearSummary($user, $year);
                break;
                
            case 'transaction_history':
                $data['transactions'] = SavingsTransaction::where('user_id', $user->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
                $data['loan_payments'] = LoanPayment::whereIn('loan_id', $loans->pluck('id'))
                    ->whereBetween('paid_at', [$startDate, $endDate])
                    ->get();
                break;
        }
        
        return $data;
    }

    /**
     * Generate report file
     */
    private function generateReportFile($user, $reportType, $data, $format, $startDate, $endDate)
    {
        $timestamp = now()->format('Ymd_His');
        $fileName = "{$reportType}_{$user->id}_{$timestamp}.{$format}";
        $filePath = storage_path('app/reports/' . $fileName);
        
        if (!Storage::exists('reports')) {
            Storage::makeDirectory('reports');
        }
        
        switch ($format) {
            case 'pdf':
                $pdf = PDF::loadView('member.reports.pdf.' . $reportType, $data);
                $pdf->save($filePath);
                break;
                
            case 'excel':
                // You would use Laravel Excel package here
                // For now, create a CSV as placeholder
                $this->generateCSVReport($reportType, $data, $filePath);
                break;
                
            case 'csv':
                $this->generateCSVReport($reportType, $data, $filePath);
                break;
        }
        
        return $fileName;
    }

    /**
     * Generate CSV report
     */
    private function generateCSVReport($reportType, $data, $filePath)
    {
        $handle = fopen($filePath, 'w');
        
        switch ($reportType) {
            case 'savings_statement':
                fputcsv($handle, ['Date', 'Description', 'Transaction Type', 'Amount', 'Balance', 'Reference', 'Status']);
                
                foreach ($data['transactions'] as $transaction) {
                    fputcsv($handle, [
                        $transaction->created_at->format('Y-m-d H:i:s'),
                        $transaction->description,
                        $transaction->type,
                        $transaction->amount,
                        $transaction->balance_after,
                        $transaction->reference_number,
                        $transaction->status,
                    ]);
                }
                break;
                
            case 'transaction_history':
                fputcsv($handle, ['Date', 'Type', 'Description', 'Amount', 'Account', 'Reference']);
                
                foreach ($data['transactions'] as $transaction) {
                    fputcsv($handle, [
                        $transaction->created_at->format('Y-m-d'),
                        'Savings',
                        $transaction->description,
                        $transaction->amount,
                        'Savings Account',
                        $transaction->reference,
                    ]);
                }
                
                foreach ($data['loan_payments'] as $payment) {
                    fputcsv($handle, [
                        $payment->paid_at ? $payment->paid_at->format('Y-m-d') : $payment->due_date->format('Y-m-d'),
                        'Loan Payment',
                        'Loan Repayment - ' . $payment->loan->loan_number,
                        $payment->amount_paid,
                        'Loan Account',
                        $payment->payment_reference,
                    ]);
                }
                break;
        }
        
        fclose($handle);
    }

    /**
     * Store report record in database
     */
    private function storeReportRecord($user, $reportType, $fileName, $startDate, $endDate, $format)
    {
        // Create report record in database
        // You would create a Report model for this
        /*
        Report::create([
            'user_id' => $user->id,
            'report_type' => $reportType,
            'file_name' => $fileName,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'format' => $format,
            'generated_at' => now(),
            'download_count' => 1,
        ]);
        */
    }

    /**
     * Get recent reports for user
     */
    private function getRecentReports($user)
    {
        // Fetch from reports table if you have one
        // For now, return empty array
        return [];
    }

    /**
     * Get opening balance for a date
     */
    private function getOpeningBalance($savings, $date)
    {
        if (!$savings) return 0;
        
        $lastTransaction = $savings->transactions()
            ->where('created_at', '<', $date)
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $lastTransaction ? $lastTransaction->balance_after : 0;
    }

    /**
     * Get savings balance at specific date
     */
    private function getSavingsBalanceAtDate($savings, $date)
    {
        return $this->getOpeningBalance($savings, $date->addDay()); // Get balance at end of previous day
    }

    /**
     * Get loan year summary
     */
    private function getLoanYearSummary($user, $year)
    {
        $loans = $user->loans()
            ->whereYear('created_at', '<=', $year)
            ->where(function($query) use ($year) {
                $query->whereNull('closed_at')
                      ->orWhereYear('closed_at', '>=', $year);
            })
            ->get();
        
        $summary = [
            'total_loans' => $loans->count(),
            'total_borrowed' => $loans->sum('amount'),
            'total_repaid' => $loans->sum('total_paid'),
            'outstanding_balance' => $loans->sum('remaining_balance'),
            'interest_paid' => $loans->sum('interest_paid'),
        ];
        
        return $summary;
    }
}