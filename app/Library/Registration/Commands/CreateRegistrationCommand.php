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
    public UserRoleValue $userRoleValue;

    public static function createFromDto(AddDto $dto): self
    {
        $command = new self();
		$command->emailValue = new EmailValue($dto->email);
		$command->passwordValue = new PasswordValue($dto->password);
        $command->userRoleValue = new UserRoleValue('user');

        return $command;
    }

    static public function createFromPrimitive(
        string $email,
        string $password,
        string $user_role
    ): self
    {
        $command = new self();

        $command->emailValue = new EmailValue($email);
        $command->passwordValue = new PasswordValue($password);
        $command->userRoleValue = new UserRoleValue($user_role);

        return $command;
    }
}