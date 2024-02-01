<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:57
 */

namespace App\Library\UserBalance\Handlers;

use App\Library\UserBalance\Commands\GetUserBalanceCommand;
use App\Library\UserBalance\Results\UserBalanceResult;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetUserBalanceHandler implements CommandHandlerContract
{
    /**
     * @param GetUserBalanceCommand $command
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::find($command->userId->value());

        if ($user?->balance) {
            return new UserBalanceResult($user->balance->balance);
        }

        return new UserBalanceResult(0);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
