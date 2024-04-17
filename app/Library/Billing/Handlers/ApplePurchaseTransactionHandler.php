<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 08:21
 */

namespace App\Library\Billing\Handlers;

use App\Exceptions\DuplicateAppleTransactionException;
use App\Exceptions\DuplicateGoogleOrderException;
use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Models\ApplePurchaseTransaction;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ApplePurchaseTransactionHandler implements CommandHandlerContract
{
    /**
     * @param ApplePurchaseTransactionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $transaction_id = $command->transactionId->value();
        $transaction = ApplePurchaseTransaction::where('transaction_id', $transaction_id)->first();

        if (!is_null($transaction)) {
            throw new DuplicateAppleTransactionException("Transaction with id $transaction_id already exists.");
        }

        ApplePurchaseTransaction::create([
            'transaction_id' => $command->transactionId->value(),
            'product_id' => $command->productId->value(),
            'type' => $command->transactionType->value(),
            'environment' => $command->environment->value(),
            'storefront' => $command->storefront->value(),
            'storefront_id' => $command->storefrontId->value(),
            'currency' => $command->currency->value(),
            'price' => $command->price->value(),
            'user_id' => $command->userId->value(),
        ]);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
