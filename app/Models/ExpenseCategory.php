<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'monthly_budget',
        'requires_approval',
        'approval_limit',
        'status',
    ];

    protected $casts = [
        'monthly_budget' => 'decimal:2',
        'approval_limit' => 'decimal:2',
        'requires_approval' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBudgetCategories($query)
    {
        return $query->where('monthly_budget', '>', 0);
    }

    // ========== BUSINESS LOGIC ==========
    
    /**
     * Get current month's total expenses
     */
    public function getCurrentMonthExpenses()
    {
        return $this->expenses()
            ->whereYear('expense_date', date('Y'))
            ->whereMonth('expense_date', date('m'))
            ->paid()
            ->sum('amount');
    }

    /**
     * Get budget utilization percentage
     */
    public function getBudgetUtilizationAttribute()
    {
        if ($this->monthly_budget <= 0) {
            return 0;
        }
        
        $currentExpenses = $this->getCurrentMonthExpenses();
        return min(100, ($currentExpenses / $this->monthly_budget) * 100);
    }

    /**
     * Check if budget is exceeded
     */
    public function isBudgetExceeded()
    {
        return $this->budget_utilization >= 100;
    }

    /**
     * Get remaining budget
     */
    public function getRemainingBudgetAttribute()
    {
        $currentExpenses = $this->getCurrentMonthExpenses();
        return max(0, $this->monthly_budget - $currentExpenses);
    }
}