<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 22.01.24
 * Time: 23:30
 */

namespace App\Library\UserDevice\Results;

use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetResult implements CommandResultContract
{
    public function __construct(readonly private UserDevice $userDevice)
    {
    }

    public function getResult(): UserDevice
    {
        return $this->userDevice;
    }
}
