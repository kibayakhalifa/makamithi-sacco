<?php

namespace Database\Seeders;

use App\Models\SavingsTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SavingsTransactionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing test transactions
        SavingsTransaction::whereIn('user_id', function($query) {
            $query->select('id')->from('users')->whereIn('email', [
                'noloan@test.com',
                'firstloan30@test.com',
                'firstloan60@test.com',
                'bothloans@test.com',
                'rejectedloan@test.com',
                'pendingloan@test.com'
            ]);
        })->delete();

        // Create transactions for each test user
        $users = User::whereIn('email', [
            'noloan@test.com',
            'firstloan30@test.com',
            'firstloan60@test.com',
            'bothloans@test.com',
            'rejectedloan@test.com',
            'pendingloan@test.com'
        ])->get();

        foreach ($users as $user) {
            $savings = $user->savings;
            if (!$savings) {
                continue;
            }

            $balance = 0;
            $currentDate = Carbon::parse('2024-01-01');

            // Create payroll deductions for the last 6 months
            for ($i = 0; $i < 6; $i++) {
                $amount = $user->monthly_savings;
                $balance += $amount;
                
                SavingsTransaction::create([
                    'user_id' => $user->id,
                    'transaction_ref' => 'PRL-' . $currentDate->format('Ym') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'type' => 'payroll_deduction',
                    'amount' => $amount,
                    'balance_before' => $balance - $amount,
                    'balance_after' => $balance,
                    'status' => 'completed',
                    'description' => 'Monthly payroll deduction',
                    'payment_method' => 'payroll',
                    'reference_number' => 'PRL' . $user->employee_number . $currentDate->format('Ym'),
                    'transaction_date' => $currentDate->copy()->addDays(25), // 25th of each month
                    'posted_date' => $currentDate->copy()->addDays(26),
                    'posted_by' => 1, // Admin user
                ]);

                // Add interest credit every 3 months
                if ($i % 3 === 0 && $i > 0) {
                    $interest = $balance * 0.05; // 5% interest
                    $balance += $interest;
                    
                    SavingsTransaction::create([
                        'user_id' => $user->id,
                        'transaction_ref' => 'INT-' . $currentDate->format('Ym') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'type' => 'interest_credit',
                        'amount' => $interest,
                        'balance_before' => $balance - $interest,
                        'balance_after' => $balance,
                        'status' => 'completed',
                        'description' => 'Quarterly interest credit',
                        'payment_method' => 'system',
                        'reference_number' => 'INT' . $user->employee_number . $currentDate->format('Ym'),
                        'transaction_date' => $currentDate->copy()->addDays(1),
                        'posted_date' => $currentDate->copy()->addDays(1),
                        'posted_by' => 1, // Admin user
                    ]);
                }

                // Add occasional voluntary deposits
                if (rand(0, 3) === 0) { // 25% chance each month
                    $voluntary = rand(1000, 10000);
                    $balance += $voluntary;
                    
                    SavingsTransaction::create([
                        'user_id' => $user->id,
                        'transaction_ref' => 'VOL-' . $currentDate->format('Ym') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'type' => 'voluntary_deposit',
                        'amount' => $voluntary,
                        'balance_before' => $balance - $voluntary,
                        'balance_after' => $balance,
                        'status' => 'completed',
                        'description' => 'Voluntary savings deposit',
                        'payment_method' => 'mpesa',
                        'reference_number' => 'MP' . rand(100000, 999999),
                        'transaction_date' => $currentDate->copy()->addDays(rand(1, 20)),
                        'posted_date' => $currentDate->copy()->addDays(rand(1, 20)),
                        'posted_by' => 1, // Admin user
                    ]);
                }

                $currentDate->addMonth();
            }

            // Update savings balance to match transactions
            $savings->update([
                'payroll_savings' => $user->monthly_savings * 6,
                'voluntary_savings' => $balance - ($user->monthly_savings * 6),
                'interest_earned' => $balance * 0.05,
                'total_savings' => $balance,
                'available_savings' => $balance,
                'loan_eligibility' => $balance * 1.5,
                'last_updated' => now(),
            ]);
        }

        echo "✅ Created savings transactions for test users\n";
    }
}