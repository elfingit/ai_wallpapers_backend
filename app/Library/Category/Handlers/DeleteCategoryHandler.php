<?php

namespace App\Library\Category\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Category\Commands\DeleteCategoryCommand;

class DeleteCategoryHandler implements CommandHandlerContract
{
    /**
     * @param DeleteCategoryCommand $command
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
