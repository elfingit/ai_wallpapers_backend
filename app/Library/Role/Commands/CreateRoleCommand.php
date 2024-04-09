<?php

namespace App\Library\Role\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Role\Values\TitleValue;
use App\Library\Role\Dto\AddDto;

class CreateRoleCommand extends AbstractCommand
{
	public TitleValue $titleValue;

    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();
		$command->titleValue = new TitleValue($dto->title);

        return $command;
    }

    public static function createFromPrimitive(string $title): self
    {
        $command             = new self();
        $command->titleValue = new TitleValue($title);

        return $command;
    }
}
