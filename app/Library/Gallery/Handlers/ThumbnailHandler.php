<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 19:04
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GalleryReplicateCommand;
use App\Library\Gallery\Commands\NotifyUserFreeGalleryCommand;
use App\Library\Gallery\Commands\PictureUploadedCommand;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ThumbnailHandler implements CommandHandlerContract
{
    /**
     * @param PictureUploadedCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::find($command->idValue->value());
        $file_path = Storage::disk('wallpaper')->path($gallery->file_path);
        $path_parts = explode('/', $gallery->file_path);
        $sub_path = implode(
            '/',
            array_slice($path_parts, 0, 2)
        );
        Storage::disk('thumbnail')
               ->makeDirectory($sub_path);

        $thumbnail_path = Storage::disk('thumbnail')->path($sub_path);

        $file_name = $path_parts[array_key_last($path_parts)];

        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read($file_path);
        $image->scale(height: 500);

        $image->save($thumbnail_path . DIRECTORY_SEPARATOR . $file_name);

        $gallery->thumbnail_path = $sub_path . DIRECTORY_SEPARATOR . $file_name;
        $gallery->save();

        if (is_null($gallery->user_id)) {
            $replicateCommand = GalleryReplicateCommand::createFromPrimitives($gallery->id);
            \CommandBus::dispatch($replicateCommand);
            $notifyCommand = NotifyUserFreeGalleryCommand::createFromPrimitives($gallery->id);
            \CommandBus::dispatch($notifyCommand);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
