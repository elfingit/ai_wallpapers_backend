<?php

namespace App\Library\User\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\User\Dto\AddDto;

class CreateUserCommand extends AbstractCommand
{


    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();


        return $command;
    }
}
