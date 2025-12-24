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
        if (!Schema::hasColumn('loan_schedules', 'notes')) {
            // FIX: use an existing column
            $table->text('notes')->nullable()->after('balance_after');
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
