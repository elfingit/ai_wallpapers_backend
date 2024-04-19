<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.04.24
 * Time: 15:43
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class NotifyUserFreeGalleryCommand extends AbstractCommand
{
    public IdValue $id;

    public static function createFromPrimitives(int $id): self
    {
        $command = new self();
        $command->id = new IdValue($id);

        return $command;
    }
}
