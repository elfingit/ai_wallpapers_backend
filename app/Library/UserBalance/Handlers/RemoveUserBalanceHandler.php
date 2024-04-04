<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 12:57
 */

namespace App\Library\UserBalance\Handlers;

use App\Library\UserBalance\Commands\RemoveUserBalanceCommand;
use App\Models\UserBalance;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class RemoveUserBalanceHandler implements CommandHandlerContract
{
    /**
     * @param RemoveUserBalanceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $userBalance = UserBalance::where('user_id', $command->userIdValue->value())->first();

        if (!$userBalance) {
            return null;
        }

        $userBalance->transactions()->delete();
        $userBalance->forceDelete();

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
