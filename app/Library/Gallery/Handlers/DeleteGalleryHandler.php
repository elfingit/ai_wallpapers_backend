<?php

namespace App\Library\Gallery\Handlers;

use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\DeleteGalleryCommand;

class DeleteGalleryHandler implements CommandHandlerContract
{
    /**
     * @param DeleteGalleryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        Gallery::find($command->idValue->value())->delete();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
