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
        $table->unsignedBigInteger('loan_id')->after('id'); // Add column
        $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade'); // optional foreign key
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_topups', function (Blueprint $table) {
        $table->dropForeign(['loan_id']); 
        $table->dropColumn('loan_id');
    });
    }
};
