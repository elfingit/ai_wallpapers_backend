<?php

namespace App\Library\Tag\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Tag\Commands\UpdateTagCommand;

class UpdateTagHandler implements CommandHandlerContract
{
    /**
     * @param UpdateTagCommand $command
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
