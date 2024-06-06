<?php

namespace App\Library\Category\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\TitleValue;
use App\Library\Category\Dto\UpdateDto;

class UpdateCategoryCommand extends AbstractCommand
{
	public TitleValue $titleValue;

    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();
		$command->titleValue = new TitleValue($dto->title);

        return $command;
    }
}
