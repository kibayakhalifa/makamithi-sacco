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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->enum('type', ['announcement', 'notice', 'memo'])->default('announcement');
            $table->enum('audience_type', ['all', 'committee', 'role', 'specific'])->default('all');
            $table->json('allowed_roles')->nullable();       // for role-based audience
            $table->json('specific_users')->nullable();      // for specific user IDs
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
