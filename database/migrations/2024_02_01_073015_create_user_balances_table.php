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
        Schema::create('user_balances', function (Blueprint $table) {
				$table->id('id');
                $table->decimal('balance', 10, 2)->default(0);
                $table->foreignId('user_id')
                      ->constrained('users')
                      ->restrictOnDelete();
				$table->timestamps();
				$table->softDeletes();

                $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balances');
    }
};