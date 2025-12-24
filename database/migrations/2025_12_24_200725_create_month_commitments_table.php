<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthCommitmentsTable extends Migration
{
    public function up()
    {
        Schema::create('month_commitments', function (Blueprint $table) {
            $table->id();
            $table->string('month', 7)->unique(); // Format: YYYY-MM
            $table->enum('status', ['draft', 'committed', 'locked'])->default('draft');
            
            // Totals
            $table->decimal('total_savings', 12, 2)->default(0);
            $table->decimal('total_loans', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->integer('member_count')->default(0);
            $table->integer('adjusted_count')->default(0);
            
            // Audit
            $table->foreignId('committed_by')->nullable()->constrained('users');
            $table->timestamp('committed_at')->nullable();
            $table->text('commitment_notes')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index(['month', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('month_commitments');
    }
}