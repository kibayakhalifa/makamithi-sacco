<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size');
            $table->string('file_type');
            $table->string('category')->default('general');
            $table->string('access_type')->default('committee'); // 'committee', 'members', 'specific_users'
            $table->json('allowed_roles')->nullable(); // ['secretary', 'chairman', 'treasurer']
            $table->json('specific_users')->nullable(); // [1, 2, 3] user IDs
            $table->foreignId('uploaded_by')->constrained('users');
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};