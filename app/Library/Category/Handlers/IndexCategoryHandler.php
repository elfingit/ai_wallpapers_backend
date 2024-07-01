<?php

namespace App\Library\Category\Handlers;

use App\Library\Category\Results\IndexResult;
use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Category\Commands\IndexCategoryCommand;

class IndexCategoryHandler implements CommandHandlerContract
{
    /**
     * @param IndexCategoryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $query = Category::query();

        if ($command->idValue) {
            $query->where('id', $command->idValue->value());
        }

        if ($command->titleValue) {
            $query->where('title', 'like', "%$command->titleValue->value()%");
        }

        $query->orderBy('id', 'desc');

        return new IndexResult($query->paginate(20));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
