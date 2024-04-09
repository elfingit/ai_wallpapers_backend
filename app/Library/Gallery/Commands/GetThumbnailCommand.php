<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.01.24
 * Time: 04:53
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetThumbnailCommand extends AbstractCommand
{
    public IdValue $idValue;

    public static function createFromPrimitives(int $id): self
    {
        $command = new self();
        $command->idValue = new IdValue($id);
        return $command;
    }
}
