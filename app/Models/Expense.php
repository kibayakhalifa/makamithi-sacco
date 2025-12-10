<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_number',
        'title',
        'description',
        'amount',
        'category_id',
        'treasurer_id',
        'requested_by',
        'approved_by',
        'expense_date',
        'payment_date',
        'status',
        'payment_status',
        'payment_method',
        'cheque_number',
        'receipt_path',
        'rejection_reason',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'payment_date' => 'date',
        'approved_at' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function treasurer()
    {
        return $this->belongsTo(Treasurer::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========== SCOPES ==========
    
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeRequiringApproval($query)
    {
        return $query->whereIn('status', ['submitted', 'pending']);
    }

    // ========== BUSINESS LOGIC ==========
    
    /**
     * Generate expense number
     */
    public static function generateExpenseNumber()
    {
        $prefix = 'EXP-';
        $year = date('Y');
        $month = date('m');
        
        $lastExpense = self::where('expense_number', 'like', $prefix . $year . $month . '%')
            ->orderBy('expense_number', 'desc')
            ->first();
        
        if ($lastExpense) {
            $lastNumber = intval(substr($lastExpense->expense_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }
        
        return $prefix . $year . $month . $nextNumber;
    }

    /**
     * Submit expense for approval
     */
    public function submitForApproval()
    {
        $this->status = 'submitted';
        $this->save();
        
        return $this;
    }

    /**
     * Approve expense
     */
    public function approve($approverId, $notes = null)
    {
        $this->status = 'approved';
        $this->approved_by = $approverId;
        $this->approved_at = now();
        $this->notes = $notes;
        $this->save();
        
        return $this;
    }

    /**
     * Reject expense
     */
    public function reject($reason)
    {
        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        $this->save();
        
        return $this;
    }

    /**
     * Mark as paid
     */
    public function markAsPaid($paymentMethod, $paymentDate = null, $chequeNumber = null)
    {
        $this->payment_status = 'paid';
        $this->payment_method = $paymentMethod;
        $this->payment_date = $paymentDate ?? now();
        $this->cheque_number = $chequeNumber;
        $this->save();
        
        return $this;
    }

    /**
     * Check if expense requires additional approval
     */
    public function requiresAdditionalApproval()
    {
        if (!$this->category) {
            return false;
        }
        
        return $this->category->approval_limit && 
               $this->amount > $this->category->approval_limit;
    }

    /**
     * Get total paid expenses for a period
     */
    public static function getTotalPaid($startDate = null, $endDate = null)
    {
        $query = self::paid();
        
        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }
        
        return $query->sum('amount');
    }

    /**
     * Get expenses summary by category
     */
    public static function getSummaryByCategory($startDate = null, $endDate = null)
    {
        $query = self::with('category')
            ->selectRaw('category_id, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('category_id');
        
        if ($startDate && $endDate) {
            $query->whereBetween('expense_date', [$startDate, $endDate]);
        }
        
        return $query->get();
    }
}