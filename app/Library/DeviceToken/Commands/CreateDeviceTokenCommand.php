<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.04.24
 * Time: 14:15
 */

namespace App\Library\DeviceToken\Commands;

use App\Library\DeviceToken\Values\DeviceIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class CreateDeviceTokenCommand extends AbstractCommand
{
    public DeviceIdValue $deviceId;

    static public function instanceFromPrimitive(string $deviceId): self
    {
        $command =  new self();
        $command->deviceId = new DeviceIdValue($deviceId);

        return $command;
    }
}
