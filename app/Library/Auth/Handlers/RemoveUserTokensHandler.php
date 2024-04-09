<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 11:10
 */

namespace App\Library\Auth\Handlers;

use App\Library\Auth\Commands\RemoveUserTokensCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class RemoveUserTokensHandler implements CommandHandlerContract
{
    /**
     * @param RemoveUserTokensCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::find($command->userIdValue->value());
        $user?->tokens()->delete();

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
