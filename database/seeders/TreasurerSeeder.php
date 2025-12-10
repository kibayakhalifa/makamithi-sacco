<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\Treasurer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TreasurerSeeder extends Seeder
{
    public function run()
    {
        // Create treasurer user
        $treasurerUser = User::create([
            'name' => 'Treasurer Wanjiru',
            'email' => 'treasurer@makamithi.com',
            'password' => Hash::make('password'),
            'role' => 'treasurer',
            'employee_number' => 'EMP003',
            'phone' => '+254712345678',
            'department' => 'Finance',
        ]);

        // Create treasurer record
        Treasurer::create([
            'user_id' => $treasurerUser->id,
            'appointment_date' => now()->subYear(),
            'term_end_date' => now()->addYears(2),
            'status' => 'active',
            'signatory_limit' => 1000000,
            'bank_signatory' => true,
            'can_issue_cheques' => true,
            'can_approve_expenses' => true,
            'can_process_loans' => true,
            'notes' => 'Main treasurer for Makamithi Sacco',
        ]);

        // Create expense categories
        $categories = [
            ['name' => 'Office Supplies', 'code' => 'OFFICE_SUPPLIES', 'monthly_budget' => 50000, 'requires_approval' => true],
            ['name' => 'Utilities', 'code' => 'UTILITIES', 'monthly_budget' => 30000, 'requires_approval' => true],
            ['name' => 'Travel & Transport', 'code' => 'TRAVEL_TRANSPORT', 'monthly_budget' => 100000, 'requires_approval' => true],
            ['name' => 'Meetings & Seminars', 'code' => 'MEETINGS_SEMINARS', 'monthly_budget' => 50000, 'requires_approval' => true],
            ['name' => 'Maintenance', 'code' => 'MAINTENANCE', 'monthly_budget' => 20000, 'requires_approval' => true],
            ['name' => 'Office Rent', 'code' => 'OFFICE_RENT', 'monthly_budget' => 50000, 'requires_approval' => true],
            ['name' => 'Bank Charges', 'code' => 'BANK_CHARGES', 'monthly_budget' => 10000, 'requires_approval' => false],
            ['name' => 'Other Expenses', 'code' => 'OTHER_EXPENSES', 'monthly_budget' => 25000, 'requires_approval' => true],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }

        $this->command->info('✅ Treasurer data seeded successfully!');
        $this->command->info('👤 Treasurer Login: treasurer@makamithi.co.ke');
        $this->command->info('🔑 Password: password');
    }
}
