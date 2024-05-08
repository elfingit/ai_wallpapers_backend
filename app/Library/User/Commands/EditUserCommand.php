<?php

namespace App\Library\User\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\User\Values\IdValue;

class EditUserCommand extends AbstractCommand
{
	public IdValue $idValue;

    public static function instanceFromPrimitive(int $id): self
    {
        $command = new self();
		$command->idValue = new IdValue($id);

        return $command;
    }
}
