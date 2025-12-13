<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Saving;
use App\Models\NextOfKin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-member {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test member with savings account for development/testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'member@makamithi.com';

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists.");
            return 1;
        }

        // Create member user
        $user = User::create([
            'name' => 'Test Member',
            'email' => $email,
            'password' => Hash::make('password123'),
            'employee_number' => 'EMP001',
            'national_id' => '12345678',
            'department' => 'Finance',
            'position' => 'Test Position',
            'employment_date' => now()->subMonths(12),
            'monthly_salary' => 100000,
            'monthly_savings' => 5000,
            'date_of_birth' => now()->subYears(30),
            'phone' => '0712345678',
            'address' => 'Test Address',
            'sacco_status' => 'active',
            'role' => 'member',
            'sacco_join_date' => now()->subMonths(6),
        ]);

        // Create savings account with initial balance
        Saving::create([
            'user_id' => $user->id,
            'account_number' => 'SAV-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'payroll_savings' => 30000,
            'voluntary_savings' => 20000,
            'interest_earned' => 2500,
            'total_deposits' => 52500,
            'total_withdrawn' => 0,
            'available_savings' => 52500,
            'loan_eligibility' => 78750, // 1.5x
            'last_updated' => now(),
        ]);

        // Create next of kin
        NextOfKin::create([
            'user_id' => $user->id,
            'name' => 'Jane Doe',
            'relationship' => 'Spouse',
            'phone' => '0712345679',
            'national_id' => '87654321',
            'address' => 'Test Address',
        ]);

        $this->info("✅ Test member created successfully!");
        $this->info("📧 Email: {$email}");
        $this->info("🔐 Password: password123");
        $this->info("💰 Savings Account: KES 52,500");
        $this->info("📊 Loan Eligibility: KES 78,750 (1.5x savings rule)");

        return 0;
    }
}
