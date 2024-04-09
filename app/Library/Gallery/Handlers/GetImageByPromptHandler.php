<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:51
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Results\GalleryResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetImageByPromptHandler implements CommandHandlerContract
{
    /**
     * @param GetImageByPromptCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::query()
                          ->where('prompt', $command->promptValue->value())
                          ->where('locale', $command->localValue->value())
                          ->orderBy('id', 'desc')
                          ->first();

        if ($gallery) {
            return new GalleryResult($gallery);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
