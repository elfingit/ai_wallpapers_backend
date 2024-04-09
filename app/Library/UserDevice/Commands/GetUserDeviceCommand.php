<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 22.01.24
 * Time: 23:27
 */

namespace App\Library\UserDevice\Commands;

use App\Library\UserDevice\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetUserDeviceCommand extends AbstractCommand
{
    public IdValue $id;

    public static function createFromPrimitive(string $id): self
    {
        $command = new self();
        $command->id = new IdValue($id);

        return $command;
    }
}
