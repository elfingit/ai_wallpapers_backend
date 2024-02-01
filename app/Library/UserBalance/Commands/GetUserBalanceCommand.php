<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:55
 */

namespace App\Library\UserBalance\Commands;

use App\Library\UserBalance\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetUserBalanceCommand extends AbstractCommand
{
    public UserIdValue $userId;

    public static function instanceFromPrimitives(int $user_id): self
    {
        $command = new self();
        $command->userId = new UserIdValue($user_id);

        return $command;
    }
}
