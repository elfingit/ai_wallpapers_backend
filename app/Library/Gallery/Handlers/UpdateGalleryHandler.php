<?php

namespace App\Library\Gallery\Handlers;

use App\Library\Tag\Commands\CreateTagCommand;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\UpdateGalleryCommand;

class UpdateGalleryHandler implements CommandHandlerContract
{
    /**
     * @param UpdateGalleryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::find($command->idValue->value());

        $tags = $command->tagsValue->value();

        $tagCommand = CreateTagCommand::createFromPrimitives($tags, $command->localeValue->value());

        $tagsResult = \CommandBus::dispatch($tagCommand)->getResult();

        $gallery->tags()->sync($tagsResult);
        $gallery->prompt = $command->promptValue->value();
        $gallery->locale = $command->localeValue->value();
        $gallery->category_id = $command->categoryIdValue->value();
        $gallery->save();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
