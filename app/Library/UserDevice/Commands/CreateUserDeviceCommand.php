<?php

namespace App\Library\UserDevice\Commands;

use App\Library\UserDevice\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\UserDevice\Values\IdValue;
use App\Library\UserDevice\Values\IpValue;
use App\Library\UserDevice\Values\UserAgentValue;

class CreateUserDeviceCommand extends AbstractCommand
{
	public IdValue $idValue;
	public IpValue $ipValue;
	public UserAgentValue $userAgentValue;
    public UserIdValue $userIdValue;

    public static function createFromPrimitive(
        string $id,
        string $ip,
        string $user_agent,
        int $user_id
    ): self {
        $command = new self();
		$command->idValue = new IdValue($id);
		$command->ipValue = new IpValue($ip);
		$command->userAgentValue = new UserAgentValue($user_agent);
        $command->userIdValue = new UserIdValue($user_id);

        return $command;
    }
}
