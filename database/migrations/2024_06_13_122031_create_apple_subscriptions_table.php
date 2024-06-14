<?php

use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
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
        Schema::create('apple_subscriptions', function (Blueprint $table) {
            $table->uuid();
            $table->string('subscription_id')->unique();
            $table->string('product_id');
            $table->unsignedMediumInteger('price');
            $table->string('currency', 4);
            $table->unsignedBigInteger('start_date');
            $table->unsignedBigInteger('end_date');
            $table->enum('status', SubscriptionStatusEnum::values());
            $table->enum('account_type', AccountTypeEnum::values());
            $table->uuid('account_uuid')->nullable()->index();
            $table->unsignedBigInteger('account_id')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apple_subscriptions');
    }
};
