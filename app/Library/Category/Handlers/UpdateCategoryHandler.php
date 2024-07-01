<?php

namespace App\Library\Category\Handlers;

use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Category\Commands\UpdateCategoryCommand;

class UpdateCategoryHandler implements CommandHandlerContract
{
    /**
     * @param UpdateCategoryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $category = Category::find($command->idValue->value());

        $translations = [];

        foreach ($command->titleValue as $key => $title) {
            $title = $title->value();
            $locale = $command->localeValue[$key]->value();

            $translations[$locale] = $title;
        }

        $category->setTranslations('title', $translations);
        $category->save();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
