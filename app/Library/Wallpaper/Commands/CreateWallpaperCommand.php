<?php

namespace App\Library\Wallpaper\Commands;

use App\Library\Wallpaper\Values\DeviceIdValue;
use App\Library\Wallpaper\Values\LocaleValue;
use App\Library\Wallpaper\Values\UserIdValue;
use App\Models\User;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Wallpaper\Values\PromptValue;
use App\Library\Wallpaper\Dto\AddDto;

class CreateWallpaperCommand extends AbstractCommand
{
	public PromptValue $promptValue;
    public ?UserIdValue $userIdValue = null;
    public ?DeviceIdValue $deviceIdValue = null;

    public LocaleValue $localeValue;

    public static function createFromDto(AddDto $dto, User | UserDevice $owner): self
    {
        $command = new self();
		$command->promptValue = new PromptValue($dto->prompt);

        if ($owner instanceof User) {
            $command->userIdValue = new UserIdValue($owner->id);
        } else if ($owner instanceof UserDevice) {
            $command->deviceIdValue = new DeviceIdValue($owner->uuid);
        }
        $command->localeValue = new LocaleValue($dto->locale);

        return $command;
    }
}
