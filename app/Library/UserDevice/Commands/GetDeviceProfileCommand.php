<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.06.24
 * Time: 10:47
 */

namespace App\Library\UserDevice\Commands;

use App\Library\UserDevice\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetDeviceProfileCommand extends AbstractCommand
{
    public IdValue $deviceId;

    public static function instanceFromPrimitives(string $device_id): self
    {
        $command = new self();
        $command->deviceId = new IdValue($device_id);
        return $command;
    }
}
