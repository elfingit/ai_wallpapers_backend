<?php

namespace App\Library\Registration\Handlers;

use App\Library\Registration\Results\RegistrationResult;
use App\Library\User\Commands\UserRegisteredCommand;
use App\Models\Role;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Registration\Commands\CreateRegistrationCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateRegistrationHandler implements CommandHandlerContract
{
    /**
     * @param CreateRegistrationCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $role = Role::where('title_slug', $command->userRoleValue->value())
                    ->first();

        if (!$role) {
            throw new ModelNotFoundException('Role not found');
        }

        $user = User::create([
            'email' => $command->emailValue->value(),
            'password' => \Hash::make($command->passwordValue->value()),
            'role_id' => $role->id,
        ]);

        $registeredCommand = UserRegisteredCommand::createFromPrimitives(
            $user->id,
            $command->localeValue->value()
        );
        \CommandBus::dispatch($registeredCommand);

        return new RegistrationResult($user);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
