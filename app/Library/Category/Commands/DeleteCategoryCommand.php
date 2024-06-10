<?php

namespace App\Library\Category\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\IdValue;

class DeleteCategoryCommand extends AbstractCommand
{
	public IdValue $idValue;

    public static function instanceFromPrimitive(int $id): self
    {
        $command = new self();
		$command->idValue = new IdValue($id);

        return $command;
    }
}
