<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 11:56
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\AppleSubscriptionCommand;
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

        dd($purchaseData);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
