<?php

namespace App\Library\Wallpaper\Commands;

use App\Library\Wallpaper\Values\LocaleValue;
use App\Library\Wallpaper\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Wallpaper\Values\PromptValue;
use App\Library\Wallpaper\Dto\AddDto;

class CreateWallpaperCommand extends AbstractCommand
{
	public PromptValue $promptValue;
    public UserIdValue $userIdValue;

    public LocaleValue $localeValue;

    public static function createFromDto(AddDto $dto, int $user_id): self
    {
        $command = new self();
		$command->promptValue = new PromptValue($dto->prompt);
        $command->userIdValue = new UserIdValue($user_id);
        $command->localeValue = new LocaleValue($dto->locale);

        return $command;
    }
}
