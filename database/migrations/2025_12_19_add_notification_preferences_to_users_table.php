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
        Schema::table('users', function (Blueprint $table) {
            // Add notification preference columns if they don't exist
            if (!Schema::hasColumn('users', 'notification_email_loans')) {
                $table->boolean('notification_email_loans')->default(true);
            }

            if (!Schema::hasColumn('users', 'notification_email_savings')) {
                $table->boolean('notification_email_savings')->default(true);
            }

            if (!Schema::hasColumn('users', 'notification_email_members')) {
                $table->boolean('notification_email_members')->default(true);
            }

            if (!Schema::hasColumn('users', 'notification_email_reports')) {
                $table->boolean('notification_email_reports')->default(true);
            }

            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notification_email_loans',
                'notification_email_savings',
                'notification_email_members',
                'notification_email_reports',
                'phone_number',
            ]);
        });
    }
};
