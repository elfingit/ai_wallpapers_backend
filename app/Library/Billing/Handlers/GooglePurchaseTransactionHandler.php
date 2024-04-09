<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:28
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\GooglePurchaseTransactionCommand;
use App\Models\GooglePurchaseTransaction;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GooglePurchaseTransactionHandler implements CommandHandlerContract
{
    /**
     * @param GooglePurchaseTransactionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        GooglePurchaseTransaction::create([
            'order_id' => $command->googleOrderId->value(),
            'purchase_state' => $command->purchaseState->value(),
            'consumption_state' => $command->consumptionState->value(),
            'purchase_type' => $command->purchaseType->value(),
            'acknowledgement_state' => $command->acknowledgementState->value(),
            'region_code' => $command->regionCode->value(),
            'user_id' => $command->userId->value(),
        ]);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
