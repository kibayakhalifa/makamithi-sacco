<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Loan identification
            $table->string('loan_number')->unique();
            $table->enum('loan_type', ['normal', 'topup'])->default('normal');
            
            // Loan details
            $table->decimal('amount', 12, 2);
            $table->decimal('interest_rate', 5, 2)->default(5.00); // Fixed 5%
            $table->decimal('interest_amount', 12, 2);
            $table->decimal('total_repayable', 12, 2);
            $table->integer('period_months');
            $table->decimal('monthly_payment', 12, 2);
            
            // Current status
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('remaining_balance', 12, 2);
            $table->integer('months_paid')->default(0);
            $table->integer('months_remaining');
            $table->decimal('percentage_paid', 5, 2)->default(0);
            
            // Top-up eligibility (50% rule)
            $table->boolean('eligible_for_topup')->default(false);
            
            // Application info
            $table->text('purpose')->nullable();
            $table->enum('application_type', ['self', 'assisted'])->default('self');
            $table->foreignId('assisted_by')->nullable()->constrained('users');
            
            // Approval workflow
            $table->enum('status', [
                'draft', 'pending', 'approved', 'rejected', 
                'disbursed', 'active', 'completed', 'defaulted'
            ])->default('draft');
            
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('disbursed_by')->nullable()->constrained('users');
            
            // Dates
            $table->date('applied_date');
            $table->date('approved_date')->nullable();
            $table->date('disbursed_date')->nullable();
            $table->date('expected_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            $table->date('next_payment_date')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status', 'loan_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};