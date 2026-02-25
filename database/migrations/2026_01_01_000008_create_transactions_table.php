<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['task_income', 'referral_income', 'lucky_income', 'withdrawal', 'manual_credit', 'manual_debit']);
            $table->decimal('amount', 12, 2);
            $table->string('description');
            $table->enum('status', ['pending', 'success', 'failed'])->default('success');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
