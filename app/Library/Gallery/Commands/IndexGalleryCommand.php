<?php

namespace App\Library\Gallery\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\IdValue;
use App\Library\Gallery\Values\PromptValue;
use App\Library\Gallery\Dto\IndexDto;

class IndexGalleryCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?PromptValue $promptValue = null;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) { 
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->prompt)) { 
			$command->promptValue = new PromptValue($dto->prompt);
		}

        return $command;
    }
}
