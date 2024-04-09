<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.01.24
 * Time: 13:20
 */

namespace App\Library\UserDevice\Results;

use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreateResult implements CommandResultContract
{
    public function __construct(private readonly UserDevice $device)
    {
    }
    public function getResult(): UserDevice
    {
        return $this->device;
    }

}
