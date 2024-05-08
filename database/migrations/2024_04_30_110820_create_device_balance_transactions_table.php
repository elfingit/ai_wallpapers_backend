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
        Schema::create('device_balance_transactions', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('device_id')->index();
            $table->decimal('amount', 10, 2);
            $table->string('notice')->nullable();
            $table->timestamps();

            $table->foreign('device_id')
                  ->references('uuid')
                  ->on('user_devices')
                  ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_balance_transactions');
    }
};
