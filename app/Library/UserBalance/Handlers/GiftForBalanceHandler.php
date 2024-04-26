<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.04.24
 * Time: 15:27
 */

namespace App\Library\UserBalance\Handlers;

use App\Library\User\Commands\UserRegisteredCommand;
use App\Library\User\Commands\UserRegisteredFromSocialNetworkCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GiftForBalanceHandler implements CommandHandlerContract
{
    /**
     * @param UserRegisteredFromSocialNetworkCommand | UserRegisteredCommand | CommandContract $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $balanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $command->userId->value(),
            1,
            'gift after registration'
        );

        \CommandBus::dispatch($balanceCommand);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
