<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 09:36
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\DeviceIdValue;
use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class SyncUserDeviceCommand extends AbstractCommand
{
    public DeviceIdValue $deviceIdValue;
    public UserIdValue $userIdValue;

    public static function instanceFromPrimitives(
        string $device_id,
        int $user_id
    ): self {
        $command = new self();
        $command->deviceIdValue = new DeviceIdValue($device_id);
        $command->userIdValue = new UserIdValue($user_id);

        return $command;
    }
}
