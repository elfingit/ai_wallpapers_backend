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
        Schema::create('apple_purchase_transactions', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('transaction_id');
            $table->string('product_id');
            $table->string('type');
            $table->string('environment');
            $table->string('storefront');
            $table->string('storefront_id');
            $table->string('currency');
            $table->unsignedInteger('price');
            $table->unsignedBigInteger('user_id')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apple_purchase_transactions');
    }
};
