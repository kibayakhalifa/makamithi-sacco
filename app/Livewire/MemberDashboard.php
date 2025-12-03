<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MemberDashboard extends Component
{
    public $member;
    public $savingsBalance;
    public $loanBalance;
    public $activeLoans;
    public $recentTransactions = [];
    
    public function mount()
    {
        // Mock data for frontend development
        $this->member = [
            'name' => 'John Mule',
            'member_number' => 'EMP001',
            'employment_date' => '2023-01-15',
            'department' => 'Finance',
        ];
        
        $this->savingsBalance = 150000; // KES
        $this->loanBalance = 75000; // KES
        
        $this->activeLoans = [
            [
                'id' => 1,
                'amount' => 150000,
                'balance' => 107500,
                'monthly_payment' => 6562.50,
                'due_date' => '2024-01-15',
                'status' => 'active'
            ]
        ];
        
        $this->recentTransactions = [
            ['date' => '2024-01-10', 'type' => 'Savings', 'amount' => 5000, 'description' => 'Monthly Contribution'],
            ['date' => '2024-01-05', 'type' => 'Loan Repayment', 'amount' => 6562.50, 'description' => 'Loan Installment'],
            ['date' => '2023-12-28', 'type' => 'Savings', 'amount' => 5000, 'description' => 'Monthly Contribution'],
        ];
    }
    
    public function render()
    {
        return view('livewire.member-dashboard');
    }
    
    // Add this method to make it invokable
    public function __invoke()
    {
        return $this->render();
    }
}