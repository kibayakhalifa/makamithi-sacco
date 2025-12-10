<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Savings breakdown
            $table->decimal('payroll_savings', 12, 2)->default(0); // From payroll
            $table->decimal('voluntary_savings', 12, 2)->default(0); // Top-ups
            $table->decimal('interest_earned', 12, 2)->default(0);
            
            // Totals
            $table->decimal('total_savings', 12, 2)->default(0); // Payroll + Voluntary + Interest
            $table->decimal('withdrawn_savings', 12, 2)->default(0);
            $table->decimal('available_savings', 12, 2)->default(0); // Total - Withdrawn
            
            // Calculations
            $table->decimal('loan_eligibility', 12, 2)->default(0); // 1.5× available_savings
            
            // Audit
            $table->date('last_updated');
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->unique(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};