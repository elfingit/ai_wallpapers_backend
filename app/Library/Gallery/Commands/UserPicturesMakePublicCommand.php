<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 10:57
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class UserPicturesMakePublicCommand extends AbstractCommand
{
    public UserIdValue $userIdValue;

    static public function instanceFromPrimitive(int $userId): self
    {
        $command = new self();
        $command->userIdValue = new UserIdValue($userId);
        return $command;
    }
}
