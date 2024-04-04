<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 11:04
 */

namespace App\Library\UserDevice\Commands;

use App\Library\UserDevice\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class RemoveUserDevicesCommand extends AbstractCommand
{
    public UserIdValue $userIdValue;

    static public function instanceFromPrimitive(int $userId): self
    {
        $command = new self();
        $command->userIdValue = new UserIdValue($userId);
        return $command;
    }
}
