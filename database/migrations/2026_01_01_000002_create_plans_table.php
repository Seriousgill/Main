<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('validity_days');
            $table->decimal('daily_task_income', 12, 2);
            $table->decimal('referral_daily_income', 12, 2);
            $table->decimal('referral_one_time_bonus', 12, 2);
            $table->decimal('minimum_withdrawal', 12, 2);
            $table->decimal('weekly_withdrawal_limit', 12, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
