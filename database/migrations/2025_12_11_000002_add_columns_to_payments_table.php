<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('type')->nullable()->after('user_id')->comment('disbursement, payment, refund, etc.');
            $table->foreignId('processed_by')->nullable()->after('posted_by')->constrained('users')->onDelete('set null');
            $table->timestamp('processed_date')->nullable()->after('processed_by');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeignIdFor('users', 'processed_by');
            $table->dropColumn(['type', 'processed_by', 'processed_date']);
        });
    }
};
