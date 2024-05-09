<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 14:38
 */

namespace App\Library\UserDevice\Commands;

use App\Library\UserDevice\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetDeviceBalanceCommand extends AbstractCommand
{
    public IdValue $deviceIdValue;

    public static function instanceFromPrimitive(string $deviceId): self
    {
        $command = new self();
        $command->deviceIdValue = new IdValue($deviceId);

        return $command;
    }
}
