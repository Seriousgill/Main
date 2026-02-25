<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lucky_wheel_rewards', function (Blueprint $table) {
            $table->id();
            $table->decimal('reward_amount', 12, 2);
            $table->decimal('probability', 8, 4);
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lucky_wheel_rewards');
    }
};
