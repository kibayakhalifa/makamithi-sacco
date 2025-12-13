<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanApplicationSubmitted extends Notification implements ShouldQueue
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
            ->subject('Loan Application Received')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("Your loan application has been received successfully.")
            ->line("Loan Details:")
            ->line("- Loan Number: " . $this->loan->loan_number)
            ->line("- Loan Amount: KES " . number_format($this->loan->amount, 2))
            ->line("- Loan Period: " . $this->loan->period_months . " months")
            ->line("- Purpose: " . $this->loan->purpose)
            ->line("Your application will be reviewed by the Chairman within 3-5 working days. We will notify you once a decision is made.")
            ->action('View Application Status', route('member.loans.show', $this->loan->id))
            ->line('Thank you for choosing Makamithi SACCO!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'loan_number' => $this->loan->loan_number,
            'amount' => $this->loan->amount,
            'type' => 'loan_application_submitted',
            'message' => "Your loan application for KES " . number_format($this->loan->amount, 2) . " (Loan #" . $this->loan->loan_number . ") has been received and is awaiting approval.",
        ];
    }
}
