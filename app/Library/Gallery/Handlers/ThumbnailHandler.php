<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 19:04
 */

namespace App\Library\Gallery\Handlers;

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
        $thumbnail_path = Storage::disk('thumbnail')->path($sub_path);
        $file_name = $path_parts[array_key_last($path_parts)];

        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read($file_path);
        $image->resize(height: 500);
        $image->save($thumbnail_path . DIRECTORY_SEPARATOR . $file_name);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
