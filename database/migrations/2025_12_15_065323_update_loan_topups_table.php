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
        Schema::table('loan_topups', function (Blueprint $table) {

            if (! Schema::hasColumn('loan_topups', 'amount')) {
                $table->decimal('amount', 15, 2)->after('loan_id');
            }

            if (! Schema::hasColumn('loan_topups', 'purpose')) {
                $table->string('purpose')->after('amount');
            }

            if (! Schema::hasColumn('loan_topups', 'repayment_period')) {
                $table->integer('repayment_period')->after('purpose');
            }

            if (! Schema::hasColumn('loan_topups', 'interest_rate')) {
                $table->decimal('interest_rate', 5, 2)->after('repayment_period');
            }

            if (! Schema::hasColumn('loan_topups', 'status')) {
                $table->string('status')->default('pending')->after('interest_rate');
            }

            if (! Schema::hasColumn('loan_topups', 'applied_at')) {
                $table->timestamp('applied_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_topups', function (Blueprint $table) {
            $table->dropColumn([
                'amount',
                'purpose',
                'repayment_period',
                'interest_rate',
                'status',
                'applied_at',
            ]);
        });
    }
};
