<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',           // ← This is correct
        'relationship',
        'phone',
        'national_id',    // ← This is correct
        'address',
        // No 'notes' column
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}