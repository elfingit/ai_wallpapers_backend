<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.06.24
 * Time: 14:23
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\IdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class RefreshGalleryCommand extends AbstractCommand
{
    public IdValue $idValue;

    static public function instanceFromPrimitive(int $id): self
    {
        $command = new self();
        $command->idValue = new IdValue($id);

        return $command;
    }
}
