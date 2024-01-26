<?php

namespace App\Library\Gallery\Handlers;

use App\Library\Tag\Commands\CreateTagCommand;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\CreateGalleryCommand;

class CreateGalleryHandler implements CommandHandlerContract
{
    /**
     * @param CreateGalleryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $tag_ids = \CommandBus::dispatch(
            CreateTagCommand::createFromPrimitives(
                $command->tagsValue->value(),
                $command->localeValue->value()
            )
        )->getResult();
        dd($tag_ids);
        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
