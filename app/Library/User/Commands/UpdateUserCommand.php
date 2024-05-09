<?php

namespace App\Library\User\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\User\Dto\UpdateDto;

class UpdateUserCommand extends AbstractCommand
{


    public static function createFromDto(UpdateDto $dto): self
    {
        $command = new self();


        return $command;
    }
}
