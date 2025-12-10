<?php

// app/database/factories/TreasurerFactory.php
namespace Database\Factories;

use App\Models\Treasurer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TreasurerFactory extends Factory
{
    protected $model = Treasurer::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'appointment_date' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
            'term_end_date' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'status' => 'active',
            'signatory_limit' => $this->faker->randomElement([500000, 1000000, 2000000, null]),
            'bank_signatory' => $this->faker->boolean(80),
            'can_issue_cheques' => true,
            'can_approve_expenses' => true,
            'can_process_loans' => true,
            'notes' => $this->faker->sentence(),
        ];
    }
}

// app/database/factories/PaymentFactory.php
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'payment_ref' => 'PAY-' . $this->faker->unique()->numerify('########'),
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(5000, 500000),
            'payment_method' => $this->faker->randomElement(['cash', 'cheque', 'bank_transfer', 'mobile_money', 'payroll']),
            'reference_number' => $this->faker->optional()->numerify('REF#####'),
            'status' => 'completed',
            'payment_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'posted_date' => now(),
            'posted_by' => User::factory(),
            'reconciled' => $this->faker->boolean(70),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}