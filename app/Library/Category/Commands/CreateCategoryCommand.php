<?php

namespace App\Library\Category\Commands;

use App\Library\Category\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\TitleValue;
use App\Library\Category\Dto\AddDto;

class CreateCategoryCommand extends AbstractCommand
{
	public TitleValue $titleValue;
    public LocaleValue $localeValue;

    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();
		$command->titleValue = new TitleValue($dto->title);
        $command->localeValue = new LocaleValue($dto->locale);

        return $command;
    }
}
