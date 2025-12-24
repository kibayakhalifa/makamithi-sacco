<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeductionFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'monthly_savings')) {
                $table->decimal('monthly_savings', 12, 2)->default(0)->after('monthly_salary');
            }
            
            if (!Schema::hasColumn('users', 'deduction_active')) {
                $table->boolean('deduction_active')->default(true)->after('monthly_savings');
            }
            
            if (!Schema::hasColumn('users', 'deduction_start_date')) {
                $table->date('deduction_start_date')->nullable()->after('deduction_active');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['monthly_savings', 'deduction_active', 'deduction_start_date']);
        });
    }
}