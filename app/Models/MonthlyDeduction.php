<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'user_id',
        'savings_amount',
        'savings_adjustment',
        'savings_final',
        'loan_amount',
        'loan_adjustment',
        'loan_final',
        'total_amount',
        'status',
        'is_adjusted',
        'adjustment_notes',
        'adjusted_by',
        'adjusted_at',
        'committed_by',
        'committed_at',
    ];

    protected $casts = [
        'savings_amount' => 'decimal:2',
        'savings_adjustment' => 'decimal:2',
        'savings_final' => 'decimal:2',
        'loan_amount' => 'decimal:2',
        'loan_adjustment' => 'decimal:2',
        'loan_final' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'adjusted_at' => 'datetime',
        'committed_at' => 'datetime',
        'is_adjusted' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User',
            'employee_number' => 'N/A',
            'department' => 'N/A'
        ]);
    }

    public function adjustedBy()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    public function committedBy()
    {
        return $this->belongsTo(User::class, 'committed_by');
    }

    // Scopes
    public function scopeForMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeCommitted($query)
    {
        return $query->where('status', 'committed');
    }

    public function scopeAdjusted($query)
    {
        return $query->where('is_adjusted', true);
    }

    // Methods
    public function canEdit()
    {
        return $this->status === 'draft';
    }

    public function applyAdjustment($type, $amount, $notes = null, $userId = null)
    {
        if (!$this->canEdit()) {
            return false;
        }

        if ($type === 'savings') {
            $this->savings_adjustment = $amount;
            $this->savings_final = $this->savings_amount + $amount;
        } elseif ($type === 'loan') {
            $this->loan_adjustment = $amount;
            $this->loan_final = $this->loan_amount + $amount;
        }

        $this->total_amount = $this->savings_final + $this->loan_final;
        $this->is_adjusted = true;
        $this->adjustment_notes = $notes;
        $this->adjusted_by = $userId ?? auth()->id();
        $this->adjusted_at = now();

        return $this->save();
    }

    public function resetAdjustment()
    {
        if (!$this->canEdit()) {
            return false;
        }

        $this->savings_adjustment = 0;
        $this->savings_final = $this->savings_amount;
        $this->loan_adjustment = 0;
        $this->loan_final = $this->loan_amount;
        $this->total_amount = $this->savings_final + $this->loan_final;
        $this->is_adjusted = false;
        $this->adjustment_notes = null;
        $this->adjusted_by = null;
        $this->adjusted_at = null;

        return $this->save();
    }

    public function commit($userId = null)
    {
        $this->status = 'committed';
        $this->committed_by = $userId ?? auth()->id();
        $this->committed_at = now();

        return $this->save();
    }
    public function scopeOrderByUserName($query, $direction = 'asc')
    {
        return $query->join('users', 'monthly_deductions.user_id', '=', 'users.id')
            ->select('monthly_deductions.*')
            ->orderBy('users.name', $direction);
    }
}