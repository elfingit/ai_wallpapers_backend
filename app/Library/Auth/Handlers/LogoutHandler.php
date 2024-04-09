<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.02.24
 * Time: 18:20
 */

namespace App\Library\Auth\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class LogoutHandler implements CommandHandlerContract
{
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $command->user->value()->currentAccessToken()->delete();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
