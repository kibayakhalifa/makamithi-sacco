<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateMemberProfileForm extends Component
{
    use WithFileUploads;

    public $user;
    
    public $name;
    public $email;
    public $phone_number;
    public $national_id;
    public $department;
    public $position;
    public $employment_date;
    public $monthly_salary;
    public $monthly_savings;
    public $date_of_birth;
    public $address;
    
    public $photo;
    public $national_id_image;
    
    public $successMessage;
    public $errorMessage;

    public function mount()
    {
        $this->user = Auth::user();
        
        // Initialize form fields with current user data
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->national_id = $this->user->national_id;
        $this->department = $this->user->department;
        $this->position = $this->user->position;
        $this->employment_date = $this->user->employment_date?->format('Y-m-d');
        $this->monthly_salary = $this->user->monthly_salary;
        $this->monthly_savings = $this->user->monthly_savings;
        $this->date_of_birth = $this->user->date_of_birth?->format('Y-m-d');
        $this->address = $this->user->address;
    }

    public function save()
    {
        $validator = Validator::make([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'national_id' => $this->national_id,
            'department' => $this->department,
            'position' => $this->position,
            'employment_date' => $this->employment_date,
            'monthly_salary' => $this->monthly_salary,
            'monthly_savings' => $this->monthly_savings,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'photo' => $this->photo,
            'national_id_image' => $this->national_id_image,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'phone_number' => ['required', 'string', 'max:20'],
            'national_id' => ['required', 'string', 'max:20', 'unique:users,national_id,' . $this->user->id],
            'department' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:100'],
            'employment_date' => ['required', 'date'],
            'monthly_salary' => ['required', 'numeric', 'min:0'],
            'monthly_savings' => ['required', 'numeric', 'min:0', 'max:'.$this->monthly_salary],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:500'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'national_id_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validator->fails()) {
            $this->errorMessage = $validator->errors()->first();
            return;
        }

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'national_id' => $this->national_id,
                'department' => $this->department,
                'position' => $this->position,
                'employment_date' => $this->employment_date,
                'monthly_salary' => $this->monthly_salary,
                'monthly_savings' => $this->monthly_savings,
                'date_of_birth' => $this->date_of_birth,
                'address' => $this->address,
            ]);

            // Handle photo upload
            if ($this->photo) {
                $path = $this->photo->store('profile-photos', 'public');
                $this->user->update(['profile_photo_path' => $path]);
            }

            // Handle national ID image upload
            if ($this->national_id_image) {
                $path = $this->national_id_image->store('national-ids', 'public');
                $this->user->update(['national_id_image' => $path]);
            }

            $this->successMessage = 'Profile updated successfully!';
            $this->errorMessage = null;
            
            // Clear file inputs
            $this->photo = null;
            $this->national_id_image = null;
            
            // Refresh component
            $this->dispatch('profile-updated');

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to update profile: ' . $e->getMessage();
            $this->successMessage = null;
        }
    }

    public function render()
    {
        return view('livewire.profile.update-member-profile-form');
    }
}