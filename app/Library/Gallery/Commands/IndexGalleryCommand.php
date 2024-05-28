<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\DeviceIdValue;
use App\Library\Gallery\Values\IsPublicValue;
use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\QueryValue;
use App\Library\Gallery\Values\ShowByDevicesValue;
use App\Library\Gallery\Values\ShowByUserValue;
use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\IdValue;
use App\Library\Gallery\Dto\IndexDto;

class IndexGalleryCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?QueryValue $queryValue = null;

    public IsPublicValue $isPublicValue;

    public LocaleValue $localeValue;

    public ?UserIdValue $userIdValue = null;
    public ?DeviceIdValue $deviceIdValue = null;

    public ShowByUserValue $showByUserValue;
    public ShowByDevicesValue $showByDevicesValue;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) {
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->query)) {
			$command->queryValue = new QueryValue($dto->query);
		}

        $command->isPublicValue = new IsPublicValue($dto->is_public ?? false);
        $command->localeValue = new LocaleValue($dto->locale);
        $command->showByUserValue = new ShowByUserValue($dto->show_by_user ?? false);
        $command->showByDevicesValue = new ShowByDevicesValue($dto->show_by_devices ?? false);

        if (!is_null($dto->user_id)) {
            $command->userIdValue = new UserIdValue($dto->user_id);
        } else if (!is_null($dto->device_uuid)) {
            $command->deviceIdValue = new DeviceIdValue($dto->device_uuid);
        }

        return $command;
    }
}
