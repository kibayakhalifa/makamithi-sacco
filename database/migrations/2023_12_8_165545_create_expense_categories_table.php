<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('monthly_budget', 12, 2)->default(0);
            $table->boolean('requires_approval')->default(true);
            $table->integer('approval_limit')->nullable(); // Amount above which additional approval is needed
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
