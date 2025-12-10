<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('payment_ref')->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('principal', 12, 2);
            $table->decimal('interest', 12, 2);
            
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            
            $table->enum('payment_method', ['payroll', 'cash', 'bank_transfer', 'mobile_money']);
            $table->string('reference_number')->nullable();
            
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');
            
            $table->date('payment_date');
            $table->date('posted_date')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users');
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['loan_id', 'user_id', 'payment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};