<?php

namespace App\Library\UserBalance\Handlers;

use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;

class UpdateUserBalanceHandler implements CommandHandlerContract
{
    /**
     * @param UpdateUserBalanceCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::findOrFail($command->userId->value());

        if (!$user->balance) {
            $user->balance()->create([
                'balance' => $command->balanceAmount->value()
            ]);
        } else {
            $user->balance()->lockForUpdate()->update([
                'balance' => $user->balance->balance + $command->balanceAmount->value()
            ]);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
