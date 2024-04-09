<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 11:05
 */

namespace App\Library\UserDevice\Handlers;

use App\Library\UserDevice\Commands\RemoveUserDevicesCommand;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class RemoveUserDevicesHandler implements CommandHandlerContract
{
    /**
     * @param RemoveUserDevicesCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        UserDevice::where('user_id', $command->userIdValue->value())
            ->delete();

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
