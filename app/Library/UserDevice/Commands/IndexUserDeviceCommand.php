<?php

namespace App\Library\UserDevice\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\UserDevice\Values\IdValue;
use App\Library\UserDevice\Values\IpValue;
use App\Library\UserDevice\Values\UserAgentValue;
use App\Library\UserDevice\Dto\IndexDto;

class IndexUserDeviceCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?IpValue $ipValue = null;
	public ?UserAgentValue $user_agentValue = null;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) { 
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->ip)) { 
			$command->ipValue = new IpValue($dto->ip);
		}
		if(!is_null($dto->user_agent)) { 
			$command->user_agentValue = new UserAgentValue($dto->user_agent);
		}

        return $command;
    }
}
