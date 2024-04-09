<?php

namespace App\Library\User\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\User\Values\IdValue;
use App\Library\User\Values\EmailValue;
use App\Library\User\Dto\IndexDto;

class IndexUserCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?EmailValue $emailValue = null;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) { 
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->email)) { 
			$command->emailValue = new EmailValue($dto->email);
		}

        return $command;
    }
}
