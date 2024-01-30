<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 14:37
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\MakePictureCopyCommand;
use App\Library\Gallery\Results\GalleryResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class MakePictureCopyHandler implements CommandHandlerContract
{
    /**
     * @param MakePictureCopyCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $originalGallery = Gallery::find($command->idValue->value());

        $gallery = Gallery::query()
            ->where('prompt', $originalGallery->prompt)
            ->where('locale', $originalGallery->locale)
            ->where('user_id', $command->userIdValue->value())
            ->first();

        if (!$gallery) {
            $gallery = Gallery::create([
                'file_path' => $originalGallery->file_path,
                'thumbnail_path' => $originalGallery->thumbnail_path,
                'prompt' => $originalGallery->prompt,
                'locale' => $originalGallery->locale,
                'user_id' => $command->userIdValue->value(),
            ]);
        }

        return new GalleryResult($gallery);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
