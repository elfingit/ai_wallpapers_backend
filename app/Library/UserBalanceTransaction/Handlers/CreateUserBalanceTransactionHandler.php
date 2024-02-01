<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:07
 */

namespace App\Library\UserBalanceTransaction\Handlers;

use App\Library\UserBalanceTransaction\Commands\CreateUserBalanceTransactionCommand;
use App\Models\UserBalanceTransaction;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreateUserBalanceTransactionHandler implements CommandHandlerContract
{
    /**
     * @param CreateUserBalanceTransactionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        UserBalanceTransaction::create([
            'balance_id' => $command->balanceId->value(),
            'amount' => $command->amount->value(),
            'notice' => $command->notice?->value(),
        ]);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
