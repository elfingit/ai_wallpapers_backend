<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.06.24
 * Time: 14:25
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\PictureUploadedCommand;
use App\Library\Gallery\Commands\RefreshGalleryCommand;
use App\Library\Wallpaper\Contracts\ImageGeneratorServiceContract;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class RefreshGalleryHandler implements CommandHandlerContract
{
    private ImageGeneratorServiceContract $aiService;

    public function __construct()
    {
        $this->aiService = app(config('ai.current_service'));
    }

    /**
     * @param RefreshGalleryCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $gallery = Gallery::find($command->idValue->value());

        if (
            !$gallery
            || is_null($gallery->style)
            || (is_null($gallery->user_id) && is_null($gallery->device_uuid))) {
            return null;
        }

        $prompt = $gallery->revised_prompt;
        $style = $gallery->style;

        $image_data = $this->aiService->getImageByPrompt($prompt, $style);
        $gallery->file_path = $image_data['file_path'];
        $gallery->save();
        $gallery->refresh();

        \CommandBus::dispatch(
            PictureUploadedCommand::createFromPrimitives(
                $gallery->id
            )
        );

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
