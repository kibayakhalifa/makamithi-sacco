<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Treasurer Table (no dependencies)
        Schema::create('treasurers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->date('term_end_date');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->decimal('signatory_limit', 15, 2)->nullable();
            $table->boolean('bank_signatory')->default(false);
            $table->boolean('can_issue_cheques')->default(true);
            $table->boolean('can_approve_expenses')->default(true);
            $table->boolean('can_process_loans')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Expenses Table (depends on expense_categories and treasurers)
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->foreignId('category_id')->constrained('expense_categories')->onDelete('restrict');
            $table->foreignId('treasurer_id')->constrained('treasurers')->onDelete('restrict');
            $table->foreignId('requested_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->date('expense_date');
            $table->date('payment_date')->nullable();
            $table->enum('status', ['draft', 'submitted', 'pending', 'approved', 'rejected', 'paid'])->default('draft');
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'payment_status']);
            $table->index('expense_date');
            $table->index('category_id');
        });

        // 4. Bank Reconciliations Table (no dependencies - MUST come before payments)
        Schema::create('bank_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->date('reconciliation_date');
            $table->decimal('bank_statement_balance', 15, 2);
            $table->decimal('system_balance', 15, 2);
            $table->decimal('difference', 15, 2);
            $table->enum('status', ['balanced', 'unbalanced'])->default('balanced');
            $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('statement_file_path')->nullable();
            $table->timestamps();
            
            $table->index(['reconciliation_date', 'status']);
            $table->index(['performed_by', 'reconciliation_date']);
        });

        // 5. Payments Table (depends on bank_reconciliations, expenses, loans, savings_transactions)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_ref')->unique();
            $table->foreignId('loan_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('savings_transaction_id')->nullable()->constrained('savings_transactions')->onDelete('cascade');
            $table->foreignId('expense_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('principal', 15, 2)->nullable();
            $table->decimal('interest', 15, 2)->nullable();
            $table->decimal('balance_before', 15, 2)->nullable();
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->enum('payment_method', ['cash', 'cheque', 'bank_transfer', 'mobile_money', 'payroll'])->default('bank_transfer');
            $table->string('reference_number')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->date('payment_date');
            $table->timestamp('posted_date')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('reconciled')->default(false);
            $table->timestamp('reconciled_at')->nullable();
            $table->foreignId('reconciliation_id')->nullable()->constrained('bank_reconciliations')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['payment_date', 'status']);
            $table->index(['loan_id', 'status']);
            $table->index(['reconciled', 'payment_date']);
        });

        
    }

    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bank_reconciliations');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('treasurers');
    }
};