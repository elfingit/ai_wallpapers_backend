<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 11:08
 */

namespace App\Library\Auth\Commands;

use App\Library\Auth\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class RemoveUserTokensCommand extends AbstractCommand
{
    public UserIdValue $userIdValue;

    static public function instanceFromPrimitive(int $user_id): self
    {
        $command = new self();
        $command->userIdValue = new UserIdValue($user_id);
        return $command;
    }
}
