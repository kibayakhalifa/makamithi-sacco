<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Loan $loan, public string $reason = '')
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Loan Application - Decision')
            ->greeting('Hello ' . $notifiable->name)
            ->line("Unfortunately, your loan application has been rejected.")
            ->line("Loan Details:")
            ->line("- Loan Amount: KES " . number_format($this->loan->amount, 2))
            ->line("- Loan Period: " . $this->loan->period_months . " months")
            ->when(!empty($this->reason), function ($message) {
                return $message->line("Reason for Rejection: " . $this->reason);
            })
            ->line("You can contact the Treasurer or Chairman to discuss the decision.")
            ->action('View Application', route('member.loans.show', $this->loan->id))
            ->line('Thank you for considering Makamithi SACCO!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'loan_number' => $this->loan->loan_number,
            'amount' => $this->loan->amount,
            'type' => 'loan_rejected',
            'reason' => $this->reason,
            'message' => "Your loan application for KES " . number_format($this->loan->amount, 2) . " has been rejected.",
        ];
    }
}
