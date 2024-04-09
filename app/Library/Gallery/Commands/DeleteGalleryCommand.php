<?php

namespace App\Library\Gallery\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\IdValue;

class DeleteGalleryCommand extends AbstractCommand
{
	public IdValue $idValue;

    public static function instanceFromPrimitive(int $id): self
    {
        $command = new self();
		$command->idValue = new IdValue($id);

        return $command;
    }
}
