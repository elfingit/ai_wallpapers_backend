<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 08:09
 */

namespace App\Library\Billing\Commands;

use App\Library\Billing\Values\AppleTransactionCurrencyValue;
use App\Library\Billing\Values\AppleTransactionEnvironmentValue;
use App\Library\Billing\Values\AppleTransactionIdValue;
use App\Library\Billing\Values\AppleTransactionPriceValue;
use App\Library\Billing\Values\AppleTransactionStorefrontIdValue;
use App\Library\Billing\Values\AppleTransactionStorefrontValue;
use App\Library\Billing\Values\AppleTransactionTypeValue;
use App\Library\Billing\Values\ProductIdValue;
use App\Library\Billing\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class ApplePurchaseTransactionCommand extends AbstractCommand
{
    public AppleTransactionIdValue $transactionId;
    public ProductIdValue $productId;
    public AppleTransactionTypeValue $transactionType;
    public AppleTransactionEnvironmentValue $environment;
    public AppleTransactionStorefrontValue $storefront;
    public AppleTransactionStorefrontIdValue $storefrontId;
    public AppleTransactionCurrencyValue $currency;
    public AppleTransactionPriceValue $price;

    public UserIdValue $userId;

    public static function instanceFromPrimitives(
        string $transaction_id,
        string $product_id,
        string $transaction_type,
        string $environment,
        string $storefront,
        string $storefront_id,
        string $currency,
        int $price,
        string $user_id
    ): self {
        $instance = new self();
        $instance->transactionId = new AppleTransactionIdValue($transaction_id);
        $instance->productId = new ProductIdValue($product_id);
        $instance->transactionType = new AppleTransactionTypeValue($transaction_type);
        $instance->environment = new AppleTransactionEnvironmentValue($environment);
        $instance->storefront = new AppleTransactionStorefrontValue($storefront);
        $instance->storefrontId = new AppleTransactionStorefrontIdValue($storefront_id);
        $instance->currency = new AppleTransactionCurrencyValue($currency);
        $instance->price = new AppleTransactionPriceValue($price);
        $instance->userId = new UserIdValue($user_id);
        return $instance;
    }
}
