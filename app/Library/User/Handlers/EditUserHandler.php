<?php

namespace App\Library\User\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\User\Commands\EditUserCommand;

class EditUserHandler implements CommandHandlerContract
{
    /**
     * @param EditUserCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        throw new \Exception('Not implemented');
    }

    public function isAsync(): bool
    {
        return false;
    }
}
