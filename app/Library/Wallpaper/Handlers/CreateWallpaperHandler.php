<?php

namespace App\Library\Wallpaper\Handlers;

use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Commands\MakePictureCopyCommand;
use App\Library\Wallpaper\Infrastructure\DalleService;
use App\Library\Wallpaper\Results\GalleryResult;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Wallpaper\Commands\CreateWallpaperCommand;

class CreateWallpaperHandler implements CommandHandlerContract
{
    private DalleService $dalleService;

    public function __construct()
    {
        $this->dalleService = new DalleService();
    }

    /**
     * @param CreateWallpaperCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $prompt = $command->promptValue->value();
        $locale = $command->localeValue->value();

        $gallery = \CommandBus::dispatch(GetImageByPromptCommand::instanceFromPrimitives(
            $prompt,
            $locale
        ))->getResult();

        if ($gallery) {
            $newGallery = \CommandBus::dispatch(
                MakePictureCopyCommand::instanceFromPrimitives(
                    $gallery->id,
                    $command->userIdValue->value()
                ))->getResult();

            return new GalleryResult($newGallery);
        }

        $image = $this->dalleService->getImageByPrompt($prompt);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
