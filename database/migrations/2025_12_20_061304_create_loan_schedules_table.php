<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->integer('installment_number');
            $table->date('due_date');
            $table->decimal('amount_due', 12, 2)->default(0);
            $table->decimal('principal', 12, 2)->default(0);
            $table->decimal('interest', 12, 2)->default(0);
            $table->decimal('penalty', 12, 2)->default(0);
            $table->decimal('balance_before', 12, 2)->default(0);
            $table->decimal('balance_after', 12, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->date('paid_date')->nullable();
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->string('payment_reference')->nullable();
            $table->boolean('is_adjusted')->default(false);
            $table->text('adjustment_notes')->nullable();
            $table->timestamps();

            $table->unique(['loan_id', 'installment_number']);
            $table->index(['loan_id', 'due_date']);
            $table->index(['loan_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_schedules');
    }
}