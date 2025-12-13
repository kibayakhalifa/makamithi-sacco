<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Loan $loan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Loan Application Approved')
            ->greeting('Great news!')
            ->line("Your loan application has been approved by the Chairman.")
            ->line("Loan Details:")
            ->line("- Loan Amount: KES " . number_format($this->loan->amount, 2))
            ->line("- Loan Period: " . $this->loan->period_months . " months")
            ->line("- Monthly Payment: KES " . number_format($this->loan->monthly_payment, 2))
            ->line("- Total Repayable: KES " . number_format($this->loan->total_repayable, 2))
            ->line("Your loan has been approved. The Treasurer will now process the disbursement.")
            ->action('View Loan Details', route('member.loans.show', $this->loan->id))
            ->line('Thank you for being a member of Makamithi SACCO!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'loan_number' => $this->loan->loan_number,
            'amount' => $this->loan->amount,
            'type' => 'loan_approved',
            'message' => "Your loan application for KES " . number_format($this->loan->amount, 2) . " has been approved by the Chairman.",
        ];
    }
}
