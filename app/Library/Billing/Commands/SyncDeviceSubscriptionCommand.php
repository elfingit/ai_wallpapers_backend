<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 09:00
 */

namespace App\Library\Billing\Commands;

use App\Library\Billing\Values\DeviceIdValue;
use App\Library\Billing\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class SyncDeviceSubscriptionCommand extends AbstractCommand
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
