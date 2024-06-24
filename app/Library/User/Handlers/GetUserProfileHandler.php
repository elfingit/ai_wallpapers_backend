<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 09:37
 */

namespace App\Library\User\Handlers;

use App\Library\User\Commands\GetUserProfileCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetUserProfileHandler implements CommandHandlerContract
{
    /**
     * @param GetUserProfileCommand $command
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::find($command->userId->value());
    }

    public function isAsync(): bool
    {
        return false;
    }
}
