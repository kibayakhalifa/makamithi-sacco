<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // Create test member
        $member = User::create([
            'name' => 'John Mule',
            'email' => 'member@makamithi.com',
            'password' => Hash::make('password'),
            'employee_number' => 'EMP001',
            'national_id' => '12345678',
            'department' => 'Finance',
            'position' => 'Accountant',
            'employment_date' => '2023-01-15',
            'monthly_salary' => 85000,
            'monthly_savings' => 5000,
            'date_of_birth' => '1985-06-15',
            'phone' => '+254700000000',
            'address' => '123 Main Street, Nairobi',
            'sacco_status' => 'active',
            'role' => 'member',
            'sacco_join_date' => '2023-01-15',
        ]);

        // Create savings account
        Saving::createForNewMember($member, $member->monthly_savings);

        // Create next of kin
        $member->nextOfKin()->create([
            'name' => 'Jane Doe',
            'relationship' => 'Spouse',
            'phone' => '+254711111111',
            'national_id' => '87654321',
            'address' => 'Same as member address',
            // 'notes' => 'Primary beneficiary',
        ]);
    }
}