<?php

namespace App\Library\Wallpaper\Handlers;

use App\Library\Wallpaper\Infrastructure\DalleService;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Wallpaper\Commands\CreateWallpaperCommand;

class CreateWallpaperHandler implements CommandHandlerContract
{
    private DalleService $dalleService;

    public function __construct(DalleService $dalleService)
    {
        $this->dalleService = $dalleService;
    }

    /**
     * @param CreateWallpaperCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $prompt = $command->promptValue->value();

        $image = $this->dalleService->getImageByPrompt($prompt);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
