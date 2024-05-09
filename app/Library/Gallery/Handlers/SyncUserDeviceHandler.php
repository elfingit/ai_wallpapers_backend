<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 09:37
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\SyncUserDeviceCommand;
use App\Models\Gallery;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class SyncUserDeviceHandler implements CommandHandlerContract
{
    /**
     * @param SyncUserDeviceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::where('uuid', $command->deviceIdValue->value())
            ->first();
        Gallery::query()->where('device_uuid', $device->uuid)
            ->update(['user_id' => $command->userIdValue->value()]);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
