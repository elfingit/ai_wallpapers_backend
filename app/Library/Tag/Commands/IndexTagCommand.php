<?php

namespace App\Library\Tag\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Tag\Values\IdValue;
use App\Library\Tag\Values\TitlesValue;
use App\Library\Tag\Dto\IndexDto;

class IndexTagCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?TitlesValue $titleValue = null;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) {
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->title)) {
			$command->titleValue = new TitlesValue($dto->title);
		}

        return $command;
    }
}
