<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoanDisbursed extends Notification implements ShouldQueue
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
            ->subject('Your Loan Has Been Disbursed')
            ->greeting('Great news, ' . $notifiable->name . '!')
            ->line("Your loan has been successfully disbursed.")
            ->line("Loan Details:")
            ->line("- Loan Number: " . $this->loan->loan_number)
            ->line("- Loan Amount: KES " . number_format($this->loan->amount, 2))
            ->line("- Monthly Payment: KES " . number_format($this->loan->monthly_payment, 2))
            ->line("- First Payment Due: " . $this->loan->next_payment_date?->format('d M Y'))
            ->line("Please note that repayment will begin next month. Ensure you maintain your contributions to avoid any issues.")
            ->action('View Loan Details', route('member.loans.show', $this->loan->id))
            ->line('Thank you for your continued membership in Makamithi SACCO!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'loan_number' => $this->loan->loan_number,
            'amount' => $this->loan->amount,
            'type' => 'loan_disbursed',
            'message' => "Your loan #" . $this->loan->loan_number . " for KES " . number_format($this->loan->amount, 2) . " has been disbursed. Repayment starts next month.",
        ];
    }
}
