<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.01.24
 * Time: 04:55
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GetThumbnailCommand;
use App\Library\Gallery\Results\ThumbnailResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Support\Facades\Storage;

class GetThumbnailHandler implements CommandHandlerContract
{
    /**
     * @param GetThumbnailCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::find($command->idValue->value());

        if ($gallery === null) {
            return null;
        }

        if (!is_null($gallery->thumbnail_path)) {
            return new ThumbnailResult(Storage::disk('thumbnail')->path($gallery->thumbnail_path));
        }

        return new ThumbnailResult(Storage::disk('wallpaper')->path($gallery->file_path));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
