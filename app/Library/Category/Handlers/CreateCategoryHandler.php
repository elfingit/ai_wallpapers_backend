<?php

namespace App\Library\Category\Handlers;

use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Category\Commands\CreateCategoryCommand;

class CreateCategoryHandler implements CommandHandlerContract
{
    /**
     * @param CreateCategoryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $model = new Category();
        $model->setTranslation('title', $command->localeValue->value(), $command->titleValue->value());
        $model->save();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
