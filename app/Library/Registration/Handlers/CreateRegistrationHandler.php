<?php

namespace App\Library\Registration\Handlers;

use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Registration\Commands\CreateRegistrationCommand;

class CreateRegistrationHandler implements CommandHandlerContract
{
    /**
     * @param CreateRegistrationCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::create([
            'email' => $command->emailValue->value(),
            'password' => \Hash::make($command->passwordValue->value()),
            'role' => $command->userRoleValue->value(),
        ]);


    }

    public function isAsync(): bool
    {
        return false;
    }
}
