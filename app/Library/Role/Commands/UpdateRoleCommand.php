<?php

namespace App\Library\Role\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Role\Values\TitleValue;
use App\Library\Role\Dto\UpdateDto;

class UpdateRoleCommand extends AbstractCommand
{
	public TitleValue $titleValue;

    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();
		$command->titleValue = new TitleValue($dto->title);

        return $command;
    }
}
