<?php

namespace App\Library\Role\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Role\Values\IdValue;

class EditRoleCommand extends AbstractCommand
{
	public IdValue $idValue;

    public static function instanceFromPrimitive(int $id): self
    {
        $command = new self();
		$command->idValue = new IdValue($id);

        return $command;
    }
}
