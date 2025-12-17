<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoanTestSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing test data (optional - be careful in production!)
        // If you want to clear existing test users, uncomment this:
        /*
        User::whereIn('email', [
            'noloan@test.com',
            'firstloan30@test.com',
            'firstloan60@test.com',
            'bothloans@test.com',
            'rejectedloan@test.com',
            'pendingloan@test.com'
        ])->delete();
        */

        // Or better: Clear ALL test data first
        // Delete loans first (due to foreign key constraints)
        Loan::whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereIn('email', [
                'noloan@test.com',
                'firstloan30@test.com',
                'firstloan60@test.com',
                'bothloans@test.com',
                'rejectedloan@test.com',
                'pendingloan@test.com'
            ]);
        })->delete();

        // Delete savings
        \App\Models\Saving::whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereIn('email', [
                'noloan@test.com',
                'firstloan30@test.com',
                'firstloan60@test.com',
                'bothloans@test.com',
                'rejectedloan@test.com',
                'pendingloan@test.com'
            ]);
        })->delete();

        // Delete users
        User::whereIn('email', [
            'noloan@test.com',
            'firstloan30@test.com',
            'firstloan60@test.com',
            'bothloans@test.com',
            'rejectedloan@test.com',
            'pendingloan@test.com'
        ])->delete();

        // Create test users with different loan scenarios
        
        // ============ USER 1: No Loans ============
        $user1 = User::create([
            'name' => 'John Doe - No Loans',
            'email' => 'noloan@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1001',
            'phone_number' => '0711000001',
            'department' => 'Information Technology',
            'position' => 'Software Developer',
            'monthly_salary' => 150000,
            'monthly_savings' => 15000,
            'date_of_birth' => '1990-01-15',
            'address' => '123 Test Street, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2023-01-01',
            'national_id' => '30001111', // Changed to unique
            'employment_date' => '2020-03-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create savings record for user 1
        \App\Models\Saving::create([
            'user_id' => $user1->id,
            'payroll_savings' => 45000,
            'voluntary_savings' => 5000,
            'interest_earned' => 500,
            'total_savings' => 50500,
            'available_savings' => 50000,
            'loan_eligibility' => 250000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 1: No Loans User (Available Savings: KES 50,000)\n";

        // ============ USER 2: First Loan (30% Paid) ============
        $user2 = User::create([
            'name' => 'Jane Smith - First Loan 30%',
            'email' => 'firstloan30@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1002',
            'phone_number' => '0711000002',
            'department' => 'Human Resources',
            'position' => 'HR Manager',
            'monthly_salary' => 180000,
            'monthly_savings' => 18000,
            'date_of_birth' => '1988-05-20',
            'address' => '456 HR Avenue, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2022-06-01',
            'national_id' => '30002222', // Changed to unique
            'employment_date' => '2019-08-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Saving::create([
            'user_id' => $user2->id,
            'payroll_savings' => 60000,
            'voluntary_savings' => 15000,
            'interest_earned' => 1000,
            'total_savings' => 76000,
            'available_savings' => 75000,
            'loan_eligibility' => 375000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // First loan - 30% paid
        $firstLoan1 = Loan::create([
            'user_id' => $user2->id,
            'loan_number' => 'LN-20241201-0001',
            'loan_type' => 'first_loan',
            'amount' => 100000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 5000.00,
            'total_repayable' => 105000.00,
            'period_months' => 12,
            'monthly_payment' => 8750.00,
            'amount_paid' => 31500.00, // 30% of total repayable
            'remaining_balance' => 73500.00,
            'months_paid' => 4,
            'months_remaining' => 8,
            'percentage_paid' => 30.00,
            'purpose' => 'Home Renovation',
            'application_type' => 'self',
            'status' => 'active',
            'applied_date' => now()->subMonths(4),
            'approved_date' => now()->subMonths(4)->addDays(5),
            'disbursed_date' => now()->subMonths(4)->addDays(7),
            'expected_completion_date' => now()->addMonths(8),
            'next_payment_date' => now()->addDays(15),
            'created_at' => now()->subMonths(4),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 2: First Loan 30% Paid\n";

        // ============ USER 3: First Loan (60% Paid) - ELIGIBLE FOR SECOND LOAN ============
        $user3 = User::create([
            'name' => 'Robert Johnson - First Loan 60%',
            'email' => 'firstloan60@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1003',
            'phone_number' => '0711000003',
            'department' => 'Finance',
            'position' => 'Senior Accountant',
            'monthly_salary' => 220000,
            'monthly_savings' => 22000,
            'date_of_birth' => '1985-11-30',
            'address' => '789 Finance Road, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2021-09-01',
            'national_id' => '30003333', // Changed to unique
            'employment_date' => '2018-04-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Saving::create([
            'user_id' => $user3->id,
            'payroll_savings' => 88000,
            'voluntary_savings' => 12000,
            'interest_earned' => 2000,
            'total_savings' => 102000,
            'available_savings' => 100000,
            'loan_eligibility' => 500000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // First loan - 60% paid (eligible for second loan)
        $firstLoan2 = Loan::create([
            'user_id' => $user3->id,
            'loan_number' => 'LN-20241101-0001',
            'loan_type' => 'first_loan',
            'amount' => 150000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 7500.00,
            'total_repayable' => 157500.00,
            'period_months' => 18,
            'monthly_payment' => 8750.00,
            'amount_paid' => 94500.00, // 60% of total repayable
            'remaining_balance' => 63000.00,
            'months_paid' => 11,
            'months_remaining' => 7,
            'percentage_paid' => 60.00,
            'purpose' => 'Business Expansion',
            'application_type' => 'self',
            'status' => 'active',
            'applied_date' => now()->subMonths(11),
            'approved_date' => now()->subMonths(11)->addDays(4),
            'disbursed_date' => now()->subMonths(11)->addDays(6),
            'expected_completion_date' => now()->addMonths(7),
            'next_payment_date' => now()->addDays(10),
            'created_at' => now()->subMonths(11),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 3: First Loan 60% Paid (Eligible for Second Loan)\n";

        // ============ USER 4: Both First & Second Loans ============
        $user4 = User::create([
            'name' => 'Mary Williams - Both Loans',
            'email' => 'bothloans@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1004',
            'phone_number' => '0711000004',
            'department' => 'Operations',
            'position' => 'Operations Manager',
            'monthly_salary' => 250000,
            'monthly_savings' => 25000,
            'date_of_birth' => '1983-03-25',
            'address' => '101 Operations Blvd, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2020-12-01',
            'national_id' => '30004444', // Changed to unique
            'employment_date' => '2017-06-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Saving::create([
            'user_id' => $user4->id,
            'payroll_savings' => 100000,
            'voluntary_savings' => 20000,
            'interest_earned' => 2500,
            'total_savings' => 122500,
            'available_savings' => 120000,
            'loan_eligibility' => 600000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // First loan - 50% paid
        $firstLoan3 = Loan::create([
            'user_id' => $user4->id,
            'loan_number' => 'LN-20240901-0001',
            'loan_type' => 'first_loan',
            'amount' => 200000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 10000.00,
            'total_repayable' => 210000.00,
            'period_months' => 24,
            'monthly_payment' => 8750.00,
            'amount_paid' => 105000.00, // 50% of total repayable
            'remaining_balance' => 105000.00,
            'months_paid' => 12,
            'months_remaining' => 12,
            'percentage_paid' => 50.00,
            'purpose' => 'Property Purchase',
            'application_type' => 'self',
            'status' => 'active',
            'applied_date' => now()->subMonths(12),
            'approved_date' => now()->subMonths(12)->addDays(3),
            'disbursed_date' => now()->subMonths(12)->addDays(5),
            'expected_completion_date' => now()->addMonths(12),
            'next_payment_date' => now()->addDays(5),
            'created_at' => now()->subMonths(12),
            'updated_at' => now(),
        ]);

        // Second loan (linked to first loan)
        $secondLoan = Loan::create([
            'user_id' => $user4->id,
            'loan_number' => 'LN-20241201-0002',
            'loan_type' => 'second_loan',
            'amount' => 80000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 4000.00,
            'total_repayable' => 84000.00,
            'period_months' => 12,
            'monthly_payment' => 7000.00,
            'amount_paid' => 14000.00, // ~17% paid
            'remaining_balance' => 70000.00,
            'months_paid' => 2,
            'months_remaining' => 10,
            'percentage_paid' => 16.67,
            'purpose' => 'Vehicle Purchase',
            'application_type' => 'self',
            'status' => 'active',
            'applied_date' => now()->subMonths(2),
            'approved_date' => now()->subMonths(2)->addDays(4),
            'disbursed_date' => now()->subMonths(2)->addDays(6),
            'expected_completion_date' => now()->addMonths(10),
            'next_payment_date' => now()->addDays(12),
            'parent_loan_id' => $firstLoan3->id, // Link to first loan
            'created_at' => now()->subMonths(2),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 4: Both First & Second Loans\n";

        // ============ USER 5: Rejected Loan Application ============
        $user5 = User::create([
            'name' => 'David Brown - Rejected Loan',
            'email' => 'rejectedloan@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1005',
            'phone_number' => '0711000005',
            'department' => 'Marketing',
            'position' => 'Marketing Executive',
            'monthly_salary' => 120000,
            'monthly_savings' => 12000,
            'date_of_birth' => '1992-07-10',
            'address' => '202 Marketing Lane, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2023-03-01',
            'national_id' => '30005555', // Changed to unique
            'employment_date' => '2021-02-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Saving::create([
            'user_id' => $user5->id,
            'payroll_savings' => 24000,
            'voluntary_savings' => 6000,
            'interest_earned' => 300,
            'total_savings' => 30300,
            'available_savings' => 30000,
            'loan_eligibility' => 150000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Rejected loan application
        Loan::create([
            'user_id' => $user5->id,
            'loan_number' => 'LN-20241215-0001',
            'loan_type' => 'first_loan',
            'amount' => 100000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 5000.00,
            'total_repayable' => 105000.00,
            'period_months' => 12,
            'monthly_payment' => 8750.00,
            'amount_paid' => 0.00,
            'remaining_balance' => 105000.00,
            'months_paid' => 0,
            'months_remaining' => 12,
            'percentage_paid' => 0.00,
            'purpose' => 'Education Fees',
            'application_type' => 'self',
            'status' => 'rejected',
            'rejection_reason' => 'Insufficient savings balance for requested loan amount',
            'applied_date' => now()->subDays(10),
            'approved_date' => null,
            'disbursed_date' => null,
            'expected_completion_date' => null,
            'next_payment_date' => null,
            'created_at' => now()->subDays(10),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 5: Rejected Loan Application\n";

        // ============ USER 6: Pending Loan Application ============
        $user6 = User::create([
            'name' => 'Sarah Wilson - Pending Loan',
            'email' => 'pendingloan@test.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'employee_number' => 'EMP1006',
            'phone_number' => '0711000006',
            'department' => 'Sales',
            'position' => 'Sales Representative',
            'monthly_salary' => 100000,
            'monthly_savings' => 10000,
            'date_of_birth' => '1991-12-05',
            'address' => '303 Sales Drive, Nairobi',
            'sacco_status' => 'active',
            'sacco_join_date' => '2023-05-01',
            'national_id' => '30006666', // Changed to unique
            'employment_date' => '2020-09-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Saving::create([
            'user_id' => $user6->id,
            'payroll_savings' => 32000,
            'voluntary_savings' => 8000,
            'interest_earned' => 400,
            'total_savings' => 40400,
            'available_savings' => 40000,
            'loan_eligibility' => 200000,
            'last_updated' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pending loan application
        Loan::create([
            'user_id' => $user6->id,
            'loan_number' => 'LN-20241216-0001',
            'loan_type' => 'first_loan',
            'amount' => 50000.00,
            'interest_rate' => 5.00,
            'interest_amount' => 2500.00,
            'total_repayable' => 52500.00,
            'period_months' => 12,
            'monthly_payment' => 4375.00,
            'amount_paid' => 0.00,
            'remaining_balance' => 52500.00,
            'months_paid' => 0,
            'months_remaining' => 12,
            'percentage_paid' => 0.00,
            'purpose' => 'Medical Expenses',
            'application_type' => 'self',
            'status' => 'pending',
            'applied_date' => now()->subDays(2),
            'approved_date' => null,
            'disbursed_date' => null,
            'expected_completion_date' => now()->addMonths(12),
            'next_payment_date' => null,
            'created_at' => now()->subDays(2),
            'updated_at' => now(),
        ]);

        echo "✅ Created User 6: Pending Loan Application\n";

        // ============ SUMMARY ============
        echo "\n========================================\n";
        echo "✅ SEEDER COMPLETED SUCCESSFULLY!\n";
        echo "========================================\n";
        echo "Created 6 test users with different scenarios:\n";
        echo "1. User 1: No loans (Can apply for first loan)\n";
        echo "2. User 2: First loan 30% paid (Cannot apply for second loan yet)\n";
        echo "3. User 3: First loan 60% paid (ELIGIBLE for second loan)\n";
        echo "4. User 4: Both first & second loans (Maximum loans reached)\n";
        echo "5. User 5: Rejected loan application\n";
        echo "6. User 6: Pending loan application\n";
        echo "========================================\n\n";

        echo "Login credentials for testing:\n";
        echo "All users password: password123\n";
        echo "1. No loans: noloan@test.com\n";
        echo "2. First loan 30%: firstloan30@test.com\n";
        echo "3. First loan 60%: firstloan60@test.com\n";
        echo "4. Both loans: bothloans@test.com\n";
        echo "5. Rejected loan: rejectedloan@test.com\n";
        echo "6. Pending loan: pendingloan@test.com\n";
    }
}