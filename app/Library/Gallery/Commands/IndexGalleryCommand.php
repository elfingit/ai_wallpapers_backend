<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IsPublicValue;
use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\QueryValue;
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

    public UserIdValue $userIdValue;

    public static function createFromDto(IndexDto $dto, int $user_id): self
    {
        $command = new self();
		if(!is_null($dto->id)) {
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->query)) {
			$command->queryValue = new QueryValue($dto->query);
		}

        $command->isPublicValue = new IsPublicValue($dto->is_public ?? true);
        $command->localeValue = new LocaleValue($dto->locale);
        $command->userIdValue = new UserIdValue($user_id);

        return $command;
    }
}
