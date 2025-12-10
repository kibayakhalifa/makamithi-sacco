<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cheque_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('savings_withdrawal_id')->nullable()->constrained('savings_transactions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Cheque details
            $table->string('cheque_number')->unique();
            $table->string('bank_name');
            $table->string('bank_branch');
            $table->string('account_number');
            
            // Amount and purpose
            $table->decimal('amount', 12, 2);
            $table->enum('purpose', [
                'loan_disbursement',
                'savings_withdrawal',
                'expense_payment',
                'dividend_payment',
                'other'
            ]);
            
            // Cheque status
            $table->enum('status', [
                'issued',
                'cleared',
                'bounced',
                'cancelled',
                'replaced'
            ])->default('issued');
            
            // Issue details
            $table->date('issue_date');
            $table->foreignId('issued_by')->constrained('users');
            $table->text('issue_notes')->nullable();
            
            // Clearance details
            $table->date('clearance_date')->nullable();
            $table->foreignId('cleared_by')->nullable()->constrained('users');
            $table->text('clearance_notes')->nullable();
            
            // Bounce details (if applicable)
            $table->date('bounce_date')->nullable();
            $table->text('bounce_reason')->nullable();
            $table->foreignId('replaced_by_id')->nullable()->constrained('cheque_records');
            
            $table->timestamps();
            
            $table->index(['cheque_number', 'status', 'issue_date', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cheque_records');
    }
};