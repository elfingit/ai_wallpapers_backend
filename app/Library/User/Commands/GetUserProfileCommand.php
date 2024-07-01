<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 09:36
 */

namespace App\Library\User\Commands;

use App\Library\User\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetUserProfileCommand extends AbstractCommand
{
    public IdValue $userId;

    public static function instanceFromPrimitives(int $user_id): self
    {
        $command = new self();
        $command->userId = new IdValue($user_id);
        return $command;
    }
}
