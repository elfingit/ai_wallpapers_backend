<?php

namespace App\Library\Auth\Handlers;

use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Auth\Commands\CreateAuthCommand;

class CreateAuthHandler implements CommandHandlerContract
{
    /**
     * @param CreateAuthCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = \CommandBus::dispatch(
            GetUserDeviceCommand::createFromPrimitive(
                $command->deviceIdValue->value()
            )
        );

        $user = User::where('email', $command->emailValue->value())->first();


    }

    public function isAsync(): bool
    {
        return false;
    }
}
