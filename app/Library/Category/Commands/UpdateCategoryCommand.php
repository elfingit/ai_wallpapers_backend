<?php

namespace App\Library\Category\Commands;

use App\Library\Category\Values\IdValue;
use App\Library\Category\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\TitleValue;
use App\Library\Category\Dto\UpdateDto;

class UpdateCategoryCommand extends AbstractCommand
{
	public array $titleValue;
	public array $localeValue;
    public IdValue $idValue;

    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();

        $command->titleValue = array_map(fn($title) => new TitleValue($title), $dto->titles);
        $command->localeValue = array_map(fn($locale) => new LocaleValue($locale), $dto->locales);
        $command->idValue = new IdValue($dto->id);

        return $command;
    }
}
