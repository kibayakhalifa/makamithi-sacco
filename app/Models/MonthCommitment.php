<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthCommitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'status',
        'total_savings',
        'total_loans',
        'total_amount',
        'member_count',
        'adjusted_count',
        'committed_by',
        'committed_at',
        'commitment_notes',
    ];

    protected $casts = [
        'total_savings' => 'decimal:2',
        'total_loans' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'committed_at' => 'datetime',
    ];

    // Relationships
    public function committedBy()
    {
        return $this->belongsTo(User::class, 'committed_by');
    }

    public function deductions()
    {
        return $this->hasMany(MonthlyDeduction::class, 'month', 'month');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeCommitted($query)
    {
        return $query->where('status', 'committed');
    }

    // Methods
    public function canGenerate()
    {
        return $this->status === 'draft';
    }

    public function canCommit()
    {
        return $this->status === 'draft';
    }

    public function isCommitted()
    {
        return $this->status === 'committed';
    }

    public function commitDeductions($userId = null, $notes = null)
    {
        if (!$this->canCommit()) {
            return false;
        }

        // Commit all draft deductions for this month
        $deductions = MonthlyDeduction::forMonth($this->month)->draft()->get();
        
        foreach ($deductions as $deduction) {
            $deduction->commit($userId);
        }

        // Update commitment stats
        $this->status = 'committed';
        $this->committed_by = $userId ?? auth()->id();
        $this->committed_at = now();
        $this->commitment_notes = $notes;
        
        // Recalculate totals from committed deductions
        $committedDeductions = MonthlyDeduction::forMonth($this->month)->committed()->get();
        
        $this->total_savings = $committedDeductions->sum('savings_final');
        $this->total_loans = $committedDeductions->sum('loan_final');
        $this->total_amount = $committedDeductions->sum('total_amount');
        $this->member_count = $committedDeductions->count();
        $this->adjusted_count = $committedDeductions->where('is_adjusted', true)->count();

        return $this->save();
    }

    public function getStatusBadge()
    {
        $badges = [
            'draft' => '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Draft</span>',
            'committed' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">Committed</span>',
            'locked' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-200">Locked</span>',
        ];

        return $badges[$this->status] ?? '';
    }
}