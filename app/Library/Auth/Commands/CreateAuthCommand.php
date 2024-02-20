<?php

namespace App\Library\Auth\Commands;

use App\Library\Auth\Values\IpValue;
use App\Library\Auth\Values\UserAgentValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Auth\Values\EmailValue;
use App\Library\Auth\Values\PasswordValue;
use App\Library\Auth\Values\DeviceIdValue;
use App\Library\Auth\Dto\AddDto;

class CreateAuthCommand extends AbstractCommand
{
	public EmailValue $emailValue;
	public PasswordValue $passwordValue;
	public DeviceIdValue $deviceIdValue;
    public IpValue $ipValue;
    public UserAgentValue $userAgentValue;

    public static function createFromDto(AddDto $dto, string $ip, string $user_agent): self
    {
        $command = new self();
		$command->emailValue = new EmailValue(\Str::lower($dto->email));
		$command->passwordValue = new PasswordValue($dto->password);
		$command->deviceIdValue = new DeviceIdValue($dto->device_id);
        $command->ipValue = new IpValue($ip);
        $command->userAgentValue = new UserAgentValue($user_agent);

        return $command;
    }
}
