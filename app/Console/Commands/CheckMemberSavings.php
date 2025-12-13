<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Console\Command;

class CheckMemberSavings extends Command
{
    protected $signature = 'check:member-savings {email?}';
    protected $description = 'Check if a member has a savings account';

    public function handle()
    {
        $email = $this->argument('email') ?? 'member@makamithi.com';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        $this->info("User: {$user->name} (ID: {$user->id})");
        $this->info("Email: {$user->email}");

        $saving = $user->savings;

        if (!$saving) {
            $this->warn("❌ No savings account found for this member.");
            $this->line("Creating one now...");
            
            // Create a savings account
            Saving::create([
                'user_id' => $user->id,
                'account_number' => 'SAV-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'payroll_savings' => 50000,
                'voluntary_savings' => 25000,
                'interest_earned' => 5000,
                'total_deposits' => 80000,
                'total_withdrawn' => 0,
                'available_savings' => 80000,
                'loan_eligibility' => 120000,
                'last_updated' => now(),
            ]);
            
            $this->info("✅ Savings account created successfully!");
            $this->info("💰 Initial Balance: KES 80,000");
            return 0;
        }

        $this->info("✅ Savings account found!");
        $this->info("💰 Available Savings: KES " . number_format($saving->available_savings, 2));
        $this->info("📊 Loan Eligibility: KES " . number_format($saving->loan_eligibility, 2));
        $this->info("💸 Total Deposited: KES " . number_format($saving->total_deposits, 2));

        return 0;
    }
}
