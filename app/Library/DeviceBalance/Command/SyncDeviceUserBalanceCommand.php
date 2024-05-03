<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 10:01
 */

namespace App\Library\DeviceBalance\Command;

use App\Library\DeviceBalance\Values\DeviceIdValue;
use App\Library\DeviceBalance\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class SyncDeviceUserBalanceCommand extends AbstractCommand
{
    public DeviceIdValue $deviceId;
    public UserIdValue $userId;

    public static function instanceFromPrimitives(string $device_id, int $user_id): self
    {
        $command = new self();
        $command->deviceId = new DeviceIdValue($device_id);
        $command->userId = new UserIdValue($user_id);

        return $command;
    }
}
