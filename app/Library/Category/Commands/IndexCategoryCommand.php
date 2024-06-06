<?php

namespace App\Library\Category\Commands;

use App\Library\Category\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\IdValue;
use App\Library\Category\Values\TitleValue;
use App\Library\Category\Dto\IndexDto;

class IndexCategoryCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?TitleValue $titleValue = null;
    public LocaleValue $localeValue;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();

		if(!is_null($dto->id)) {
			$command->idValue = new IdValue($dto->id);
		}

		if(!is_null($dto->title)) {
			$command->titleValue = new TitleValue($dto->title);
		}

        $command->localeValue = new LocaleValue($dto->locale);

        return $command;
    }
}
