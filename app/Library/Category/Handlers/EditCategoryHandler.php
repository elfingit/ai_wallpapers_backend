<?php

namespace App\Library\Category\Handlers;

use App\Library\Category\Results\EditResult;
use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Category\Commands\EditCategoryCommand;

class EditCategoryHandler implements CommandHandlerContract
{
    /**
     * @param EditCategoryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        return new EditResult(Category::find($command->idValue->value()));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
