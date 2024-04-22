<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 13:30
 */

namespace App\Library\Auth\Handlers;

use App\Library\Auth\Commands\GoogleSignInCommand;
use App\Library\Auth\Results\AuthResult;
use App\Library\User\Commands\UserRegisteredFromSocialNetworkCommand;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Models\Role;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GoogleSignInHandler implements CommandHandlerContract
{
    /**
     * @param GoogleSignInCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::where('email', $command->email->value())->first();

        if ($user) {
            return $this->signIn($user, $command);
        }

        return $this->createUser($command);
    }

    private function signIn(User $user, GoogleSignInCommand $command): AuthResult
    {
        if (is_null($user->params) || !isset($user->params['google_id'])) {
            $params = $user->params ?? [];
            $user->params = array_merge($params, ['google_id' => null]);
        }

        if ($user->params['google_id'] !== $command->id->value()) {
            $user->params = array_merge($user->params, ['google_id' => $command->id->value()]);
            $user->save();
        }

        $device = \CommandBus::dispatch(
            GetUserDeviceCommand::createFromPrimitive(
                $command->deviceId->value()
            )
        )->getResult();

        if (!$device) {
            $device = \CommandBus::dispatch(
                CreateUserDeviceCommand::createFromPrimitive(
                    $command->deviceId->value(),
                    $command->ip->value(),
                    $command->userAgent->value(),
                    $user->id
                )
            )->getResult();
        }

        return new AuthResult(
            $user->createToken(
                $device->uuid,
                \AbilityProvider::getAbilitiesForRole($user->role->title_slug)
            )->plainTextToken,
            $user
        );
    }

    private function createUser(GoogleSignInCommand $command): AuthResult
    {
        $password = \Str::random(16);

        $user = User::create([
            'email' => $command->email->value(),
            'password' => \Hash::make($password),
            'role_id' => Role::where('title_slug', 'user')->first()->id,
            'params' => [
                'google_id' => $command->id->value()
            ]
        ]);

        $device = \CommandBus::dispatch(
            CreateUserDeviceCommand::createFromPrimitive(
                $command->deviceId->value(),
                $command->ip->value(),
                $command->userAgent->value(),
                $user->id
            )
        )->getResult();

        $registeredCommand = UserRegisteredFromSocialNetworkCommand::instanceFromPrimitives(
            $user->id,
            $command->locale->value(),
            $password,
        );

        \CommandBus::dispatch($registeredCommand);

        return new AuthResult(
            $user->createToken(
                $device->uuid,
                \AbilityProvider::getAbilitiesForRole($user->role->title_slug)
            )->plainTextToken,
            $user
        );
    }
    public function isAsync(): bool
    {
        return false;
    }
}