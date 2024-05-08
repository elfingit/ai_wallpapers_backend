<?php

namespace App\Library\Tag\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Tag\Values\IdValue;

class DeleteTagCommand extends AbstractCommand
{
	public IdValue $idValue;

    public static function instanceFromPrimitive(int $id): self
    {
        $command = new self();
		$command->idValue = new IdValue($id);

        return $command;
    }
}
