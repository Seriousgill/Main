<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->boolean('one_time_bonus_paid')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['sponsor_id', 'referred_user_id', 'plan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
