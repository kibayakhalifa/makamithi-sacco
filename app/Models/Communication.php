<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','body','type','audience_type','allowed_roles','specific_users','created_by'
    ];

    protected $casts = [
        'allowed_roles' => 'array',
        'specific_users' => 'array',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Check if a user can access a communication
    public function canBeAccessedBy(User $user) {
        if($this->audience_type === 'all') return true;

        if($this->audience_type === 'committee') {
            return in_array($user->role, ['chairman','secretary','treasurer']);
        }

        if($this->audience_type === 'role' && $this->allowed_roles) {
            return in_array($user->role, $this->allowed_roles);
        }

        if($this->audience_type === 'specific' && $this->specific_users) {
            return in_array($user->id, $this->specific_users);
        }

        return false;
    }
    
}
