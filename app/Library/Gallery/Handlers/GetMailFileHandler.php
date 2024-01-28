<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.01.24
 * Time: 11:57
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GetMainFileCommand;
use App\Library\Gallery\Results\FilePathResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Support\Facades\Storage;

class GetMailFileHandler implements CommandHandlerContract
{
    /**
     * @param GetMainFileCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::find($command->idValue->value());

        if ($gallery === null) {
            return null;
        }

        return new FilePathResult(Storage::disk('wallpaper')->path($gallery->file_path));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
