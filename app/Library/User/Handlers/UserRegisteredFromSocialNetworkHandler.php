<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 14:37
 */

namespace App\Library\User\Handlers;

use App\Library\User\Commands\UserRegisteredFromSocialNetworkCommand;
use App\Mail\SocialWelcomeMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class UserRegisteredFromSocialNetworkHandler implements CommandHandlerContract
{
    /**
     * @param UserRegisteredFromSocialNetworkCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::findOrFail($command->userId->value());

        $welcomeMail = new SocialWelcomeMail($command->password->value());
        $welcomeMail->locale = $command->locale->value();

        \Mail::to($user)
             ->send($welcomeMail);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
