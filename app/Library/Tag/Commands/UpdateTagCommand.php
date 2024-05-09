<?php

namespace App\Library\Tag\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Tag\Values\TitlesValue;
use App\Library\Tag\Dto\UpdateDto;

class UpdateTagCommand extends AbstractCommand
{
	public TitlesValue $titleValue;

    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();
		$command->titleValue = new TitlesValue($dto->title);

        return $command;
    }
}
