<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'access_type',
        'allowed_roles',
        'specific_users',
        'uploaded_by',
        'is_public'
    ];

    protected $casts = [
        'allowed_roles' => 'array',
        'specific_users' => 'array',
        'is_public' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Check if user can access this document
     */
    public function canBeAccessedBy($user)
    {
        // Uploader can always access
        if ($this->uploaded_by == $user->id) {
            return true;
        }

        // Chairman can access everything
        if ($user->role === 'chairman') {
            return true;
        }

        // Public documents
        if ($this->is_public) {
            return true;
        }

        // Check access type
        switch ($this->access_type) {
            case 'committee':
                $roles = $this->allowed_roles ?? [];
                return in_array($user->role, $roles);
                
            case 'members':
                return $user->role === 'member';
                
            case 'specific_users':
                $users = $this->specific_users ?? [];
                return in_array($user->id, $users);
                
            default:
                return false;
        }
    }

    /**
     * Get folder for category
     */
    public function getFolderAttribute()
    {
        $folders = [
            'loans' => 'loan_documents',
            'minutes' => 'meeting_minutes',
            'members' => 'member_files',
            'financial' => 'financial_reports',
            'policy' => 'policies',
            'other' => 'documents',
        ];
        
        return $folders[$this->category] ?? 'documents';
    }
}