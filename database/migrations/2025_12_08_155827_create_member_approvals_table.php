<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'more_info'])->default('pending');
            
            $table->text('submission_notes')->nullable();
            $table->text('approval_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->dateTime('submitted_at');
            $table->dateTime('reviewed_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_approvals');
    }
};