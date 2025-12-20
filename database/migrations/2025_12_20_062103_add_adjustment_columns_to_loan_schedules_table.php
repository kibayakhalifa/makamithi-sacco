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
            $table->boolean('is_adjusted')->default(false)->after('notes');
            $table->timestamp('adjustment_date')->nullable()->after('is_adjusted');
            $table->foreignId('adjusted_by')->nullable()->after('adjustment_date')->constrained('users')->onDelete('set null');
            $table->decimal('original_amount_due', 12, 2)->nullable()->after('is_adjusted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_schedules', function (Blueprint $table) {
            $table->dropColumn(['is_adjusted', 'adjustment_date', 'adjusted_by', 'original_amount_due']);
        });
    }
};
