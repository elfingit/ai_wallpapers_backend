<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 12:55
 */

namespace App\Library\UserBalance\Commands;

use App\Library\UserBalance\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class RemoveUserBalanceCommand extends AbstractCommand
{
    public UserIdValue $userIdValue;

    static public function instanceFromPrimitive(int $user_id): self
    {
        $command = new self();
        $command->userIdValue = new UserIdValue($user_id);

        return $command;
    }
}
