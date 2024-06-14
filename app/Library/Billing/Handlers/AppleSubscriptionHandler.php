<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 11:56
 */

namespace App\Library\Billing\Handlers;

use App\Exceptions\DuplicateAppleTransactionException;
use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Library\Billing\Commands\AppleSubscriptionCommand;
use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\Billing\Results\PurchaseResult;
use App\Models\AppleSubscription;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class AppleSubscriptionHandler extends ApplePurchaseHandler
{
    /**
     * @param AppleSubscriptionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $this->logger->info('trying get purchase', [
            'extra' => [
                'product_id' => $command->productId->value(),
                'purchase_token' => $command->purchaseToken->value(),
                'user_id' => $command->userId?->value(),
                'device_id' => $command->deviceId?->value(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        $purchaseData = $this->appleService->getPurchase($command->purchaseToken->value());
        $claims = $purchaseData->claims();


        $transactionCommand = ApplePurchaseTransactionCommand::instanceFromPrimitives(
            $claims->get('transactionId'),
            $claims->get('productId'),
            $claims->get('type'),
            $claims->get('environment'),
            $claims->get('storefront'),
            $claims->get('storefrontId'),
            $claims->get('currency'),
            $claims->get('price'),
            $command->userId?->value(),
            $command->deviceId?->value()
        );

        try {
            \CommandBus::dispatch($transactionCommand);
        } catch (DuplicateAppleTransactionException $e) {
            $this->logger->warning('duplicate transaction', [
                'extra' => [
                    'transaction_id' => $claims->get('transactionId'),
                    'product_id' => $claims->get('productId'),
                    'user_id' => $command->userId?->value(),
                    'device_id' => $command->deviceId?->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new PurchaseResult(false);
        } catch (\Throwable $e) {
            $this->logger->error('error while saving transaction', [
                'extra' => [
                    'transaction_id' => $claims->get('transactionId'),
                    'product_id' => $claims->get('productId'),
                    'user_id' => $command->userId?->value(),
                    'device_id' => $command->deviceId?->value(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new PurchaseResult(false);
        }

        AppleSubscription::create([
            'subscription_id' => $claims->get('originalTransactionId'),
            'product_id' => $claims->get('productId'),
            'price' => $claims->get('price'),
            'currency' => $claims->get('currency'),
            'start_date' => $claims->get('purchaseDate'),
            'end_date' => $claims->get('expiresDate'),
            'status' => SubscriptionStatusEnum::ACTIVE,
            'account_type' => is_null($command->userId) ? AccountTypeEnum::DEVICE : AccountTypeEnum::USER,
            'account_id' => $command->userId?->value(),
            'account_uuid' => $command->deviceId?->value(),
        ]);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
