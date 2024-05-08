<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 8.05.24
 * Time: 07:33
 */

namespace App\Library\PersonalData\Commands;

use App\Library\PersonalData\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class DeleteAccountCommand extends AbstractCommand
{
    public UserIdValue $userId;

    static public function instanceFromPrimitive(int $user_id): self
    {
        $command = new self();
        $command->userId = new UserIdValue($user_id);
        return $command;
    }
}
