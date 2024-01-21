<?php

namespace App\Library\UserDevice\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\UserDevice\Commands\IndexUserDeviceCommand;

class IndexUserDeviceHandler implements CommandHandlerContract
{
    /**
     * @param IndexUserDeviceCommand $command
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
