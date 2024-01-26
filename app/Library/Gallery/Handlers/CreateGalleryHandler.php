<?php

namespace App\Library\Gallery\Handlers;

use App\Library\Tag\Commands\CreateTagCommand;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\CreateGalleryCommand;
use Illuminate\Support\Facades\Storage;

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

        $file = $command->fileValue->value();

        $original_name = $file->getClientOriginalName();
        $hashed_name = $file->hashName();

        $path_parts = array_slice(str_split(md5($original_name), 2), 0, 2);
        $path = implode(DIRECTORY_SEPARATOR, $path_parts);

        Storage::disk('wallpaper')
               ->makeDirectory($path);

        $file->storeAs($path, $hashed_name, 'wallpaper');

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
