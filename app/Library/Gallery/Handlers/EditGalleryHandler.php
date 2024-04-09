<?php

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Results\EditResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\EditGalleryCommand;

class EditGalleryHandler implements CommandHandlerContract
{
    /**
     * @param EditGalleryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        return new EditResult(Gallery::find($command->idValue->value()));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
