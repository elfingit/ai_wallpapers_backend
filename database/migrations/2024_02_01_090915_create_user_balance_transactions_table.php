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
        Schema::create('user_balance_transactions', function (Blueprint $table) {
            $table->ulid()->primary();
            $table->foreignId('balance_id')
                  ->constrained('user_balances')
                  ->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('notice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balance_transactions');
    }
};
