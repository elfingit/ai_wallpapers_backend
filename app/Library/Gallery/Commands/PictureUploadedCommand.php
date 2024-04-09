<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 19:02
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class PictureUploadedCommand extends AbstractCommand
{
    public IdValue $idValue;

    public static function createFromPrimitives(int $id): self
    {
        $command = new self();
        $command->idValue = new IdValue($id);

        return $command;
    }
}
