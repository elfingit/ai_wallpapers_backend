<?php

namespace App\Library\Registration\Commands;

use App\Library\Registration\Values\UserRoleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Registration\Values\EmailValue;
use App\Library\Registration\Values\PasswordValue;
use App\Library\Registration\Values\DeviceIdValue;
use App\Library\Registration\Dto\AddDto;

class CreateRegistrationCommand extends AbstractCommand
{
	public EmailValue $emailValue;
	public PasswordValue $passwordValue;
	public DeviceIdValue $deviceIdValue;
    public UserRoleValue $userRoleValue;

    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();
		$command->emailValue = new EmailValue($dto->email);
		$command->passwordValue = new PasswordValue($dto->password);
		$command->deviceIdValue = new DeviceIdValue($dto->device_id);
        $command->userRoleValue = new UserRoleValue('user');

        return $command;
    }
}
