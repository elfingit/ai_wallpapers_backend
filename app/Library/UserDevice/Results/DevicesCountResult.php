<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 11:07
 */

namespace App\Library\UserDevice\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class DevicesCountResult implements CommandResultContract
{
    public function __construct(readonly private int $count)
    {
    }

    public function getResult(): int
    {
        return $this->count;
    }
}
