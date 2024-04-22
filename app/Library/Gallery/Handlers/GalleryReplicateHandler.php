<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.04.24
 * Time: 15:35
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GalleryReplicateCommand;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GalleryReplicateHandler implements CommandHandlerContract
{
    /**
     * @param GalleryReplicateCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $locales = config('app.locales');
        $gallery = Gallery::find($command->id->value());

        if (is_null($gallery)) {
            return null;
        }

        foreach ($locales as $locale) {

            if ($gallery->locale == $locale) {
                continue;
            }

            $newGal = $gallery->replicate();
            $newGal->locale = $locale;
            $newGal->save();
        }

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
