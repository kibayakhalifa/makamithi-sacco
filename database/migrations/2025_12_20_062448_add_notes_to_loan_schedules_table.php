<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_schedules', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('loan_schedules', 'notes')) {
                $table->text('notes')->nullable()->after('remaining_balance');
            }
            
            // Also add other missing columns if needed
            if (!Schema::hasColumn('loan_schedules', 'is_adjusted')) {
                $table->boolean('is_adjusted')->default(false)->after('notes');
            }
            
            if (!Schema::hasColumn('loan_schedules', 'adjustment_date')) {
                $table->timestamp('adjustment_date')->nullable()->after('is_adjusted');
            }
            
            if (!Schema::hasColumn('loan_schedules', 'adjusted_by')) {
                $table->foreignId('adjusted_by')->nullable()->after('adjustment_date')->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('loan_schedules', 'original_amount_due')) {
                $table->decimal('original_amount_due', 12, 2)->nullable()->after('is_adjusted');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_schedules', function (Blueprint $table) {
            $table->dropColumn(['notes', 'is_adjusted', 'adjustment_date', 'adjusted_by', 'original_amount_due']);
        });
    }
};
