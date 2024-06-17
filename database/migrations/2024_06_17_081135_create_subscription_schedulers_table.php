<?php

use App\Library\Billing\Enums\MarketTypeEnum;
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
        Schema::create('subscription_schedulers', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('subscription_uuid')->index();
            $table->enum('market', MarketTypeEnum::values());
            $table->dateTime('next_check_date')->index();
            $table->dateTime('last_check_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_schedulers');
    }
};
