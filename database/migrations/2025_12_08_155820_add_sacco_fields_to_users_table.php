<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'employee_number')) {
                $table->string('employee_number')->unique()->nullable();
            }

            if (!Schema::hasColumn('users', 'national_id')) {
                $table->string('national_id')->unique()->nullable();
            }

            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable();
            }

            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable();
            }

            if (!Schema::hasColumn('users', 'employment_date')) {
                $table->date('employment_date')->nullable();
            }

            if (!Schema::hasColumn('users', 'monthly_salary')) {
                $table->decimal('monthly_salary', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('users', 'monthly_savings')) {
                $table->decimal('monthly_savings', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('users', 'sacco_status')) {
                $table->enum('sacco_status', ['pending', 'active', 'suspended', 'inactive'])->default('pending');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['member', 'chairman', 'treasurer', 'secretary'])->default('member');
            }

            if (!Schema::hasColumn('users', 'sacco_join_date')) {
                $table->date('sacco_join_date')->nullable();
            }

            if (!Schema::hasColumn('users', 'sacco_exit_date')) {
                $table->date('sacco_exit_date')->nullable();
            }

            if (!Schema::hasColumn('users', 'exit_reason')) {
                $table->text('exit_reason')->nullable();
            }

            if (!Schema::hasColumn('users', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users');
            }

            if (!Schema::hasColumn('users', 'approved_at')) {
                $table->dateTime('approved_at')->nullable();
            }

            // Only add the index if the columns exist or will exist
            $table->index(['employee_number', 'sacco_status', 'role']);
        });
    }



    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_number',
                'national_id',
                'department',
                'position',
                'employment_date',
                'monthly_salary',
                'monthly_savings',
                'date_of_birth',
                'phone',
                'address',
                'sacco_status',
                'role',
                'sacco_join_date',
                'sacco_exit_date',
                'exit_reason',
                'approved_by',
                'approved_at'
            ]);
        });
    }
};