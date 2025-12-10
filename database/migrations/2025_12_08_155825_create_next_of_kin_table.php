<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->enum('relationship', ['spouse', 'parent', 'sibling', 'child', 'other']);
            $table->string('phone');
            $table->string('national_id')->nullable();
            $table->text('address')->nullable();
            
            $table->timestamps();
            
            $table->unique(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('next_of_kin');
    }
};