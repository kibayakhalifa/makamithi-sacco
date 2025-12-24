<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyDeductionsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('month', 7); // Format: YYYY-MM
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Savings deduction (fixed monthly amount from user.monthly_savings)
            $table->decimal('savings_amount', 12, 2)->default(0);
            $table->decimal('savings_adjustment', 12, 2)->default(0); // One-off adjustment
            $table->decimal('savings_final', 12, 2)->default(0); // savings_amount + savings_adjustment
            
            // Loan deductions (sum of active loan monthly_payment)
            $table->decimal('loan_amount', 12, 2)->default(0);
            $table->decimal('loan_adjustment', 12, 2)->default(0); // One-off adjustment
            $table->decimal('loan_final', 12, 2)->default(0); // loan_amount + loan_adjustment
            
            // Total
            $table->decimal('total_amount', 12, 2)->default(0); // savings_final + loan_final
            
            // Status
            $table->enum('status', ['draft', 'committed'])->default('draft');
            $table->boolean('is_adjusted')->default(false);
            
            // Audit
            $table->text('adjustment_notes')->nullable();
            $table->foreignId('adjusted_by')->nullable()->constrained('users');
            $table->timestamp('adjusted_at')->nullable();
            $table->foreignId('committed_by')->nullable()->constrained('users');
            $table->timestamp('committed_at')->nullable();
            
            $table->timestamps();
            
            // Unique constraint: one deduction record per member per month
            $table->unique(['month', 'user_id']);
            
            // Indexes
            $table->index(['month', 'status']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_deductions');
    }
}