<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.02.24
 * Time: 18:17
 */

namespace App\Library\Auth\Commands;

use App\Library\Auth\Values\UserValue;
use App\Models\User;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class LogoutCommand extends AbstractCommand
{
    public UserValue $user;

    public static function instanceFromModel(User $user): self
    {
        $command = new self();
        $command->user = new UserValue($user);
        return $command;
    }
}
