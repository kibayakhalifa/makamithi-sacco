<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Office Supplies', 'code' => 'OFF-SUP', 'monthly_budget' => 50000],
            ['name' => 'Utilities', 'code' => 'UTILITIES', 'monthly_budget' => 100000],
            ['name' => 'Salaries', 'code' => 'SALARIES', 'monthly_budget' => 500000],
            ['name' => 'Loan Disbursements', 'code' => 'LOAN-DISB', 'monthly_budget' => 2000000],
            ['name' => 'Transport & Travel', 'code' => 'TRAVEL', 'monthly_budget' => 150000],
            ['name' => 'Training & Development', 'code' => 'TRAINING', 'monthly_budget' => 100000],
            ['name' => 'Maintenance', 'code' => 'MAINTENANCE', 'monthly_budget' => 75000],
            ['name' => 'Bank Charges', 'code' => 'BANK-CHG', 'monthly_budget' => 30000],
            ['name' => 'Miscellaneous', 'code' => 'MISC', 'monthly_budget' => 50000],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}