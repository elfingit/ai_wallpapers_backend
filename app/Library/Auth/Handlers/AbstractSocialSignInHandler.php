<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 11:00
 */

namespace App\Library\Auth\Handlers;

use App\Library\DeviceBalance\Command\SyncDeviceUserBalanceCommand;
use App\Library\Gallery\Commands\SyncUserDeviceCommand;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;

abstract class AbstractSocialSignInHandler implements CommandHandlerContract
{
    protected function syncUserDevice(int $user_id, string $device_id): void
    {
        $syncGalleryCommand = SyncUserDeviceCommand::instanceFromPrimitives(
            $device_id,
            $user_id,
        );

        $syncBalanceCommand = SyncDeviceUserBalanceCommand::instanceFromPrimitives(
            $device_id,
            $user_id,
        );

        \CommandBus::dispatch($syncGalleryCommand);
        \CommandBus::dispatch($syncBalanceCommand);
    }
}
