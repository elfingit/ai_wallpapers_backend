<?php

namespace App\Library\Gallery\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\FileValue;
use App\Library\Gallery\Values\PromptValue;
use App\Library\Gallery\Dto\UpdateDto;

class UpdateGalleryCommand extends AbstractCommand
{
	public PromptValue $promptValue;

    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();
		$command->promptValue = new PromptValue($dto->prompt);

        return $command;
    }
}
