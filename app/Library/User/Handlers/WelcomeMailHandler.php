<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.02.24
 * Time: 12:37
 */

namespace App\Library\User\Handlers;

use App\Library\User\Commands\UserRegisteredCommand;
use App\Mail\WelcomeMail;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class WelcomeMailHandler implements CommandHandlerContract
{
    /**
     * @param UserRegisteredCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::findOrFail($command->idValue->value());

        $welcomeMail = new WelcomeMail();
        $welcomeMail->locale = $command->localeValue->value();

        \Mail::to($user)
            ->send($welcomeMail);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
