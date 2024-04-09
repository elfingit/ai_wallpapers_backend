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
        Schema::create('google_purchase_transactions', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('order_id');
            $table->tinyInteger('purchase_state');
            $table->tinyInteger('consumption_state');
            $table->tinyInteger('purchase_type');
            $table->tinyInteger('acknowledgement_state');
            $table->string('region_code', 4);
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
        Schema::dropIfExists('google_purchase_transactions');
    }
};
