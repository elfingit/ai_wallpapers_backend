<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 14:35
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IdValue;
use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class MakePictureCopyCommand extends AbstractCommand
{
    public IdValue $idValue;
    public UserIdValue $userIdValue;

    public static function instanceFromPrimitives(int $gallery_id, int $user_id): self
    {
        $command = new self();
        $command->idValue = new IdValue($gallery_id);
        $command->userIdValue = new UserIdValue($user_id);

        return $command;
    }
}
