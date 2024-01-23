<?php

namespace App\Library\Auth\Handlers;

use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Auth\Commands\CreateAuthCommand;
use Illuminate\Auth\AuthenticationException;

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
        )->getResult();

        $user = User::where('email', $command->emailValue->value())->first();

        if (!$user || !\Hash::check($command->passwordValue->value(), $user->password)) {
            throw new AuthenticationException(__('Invalid credentials.'));
        }

        if (!$device) {
            $device = \CommandBus::dispatch(
                CreateUserDeviceCommand::createFromPrimitive(
                    $command->deviceIdValue->value(),
                    $command->ipValue->value(),
                    $command->userAgentValue->value(),
                    $user->id
                )
            )->getResult();
        }

        $token = $user->createToken($device->uuid)->plainTextToken;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
