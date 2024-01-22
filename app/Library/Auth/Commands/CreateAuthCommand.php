<?php

namespace App\Library\Auth\Commands;

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

    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();
		$command->emailValue = new EmailValue($dto->email);
		$command->passwordValue = new PasswordValue($dto->password);
		$command->deviceIdValue = new DeviceIdValue($dto->device_id);

        return $command;
    }
}
