<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.01.24
 * Time: 09:36
 */

namespace App\Library\Role\Results;

use App\Library\Role\Values\IdValue;
use App\Models\Role;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreatedRoleResult implements CommandResultContract
{
    public function __construct(private Role $role) {}

    public function getResult(): IdValue
    {
        return new IdValue($this->role->id);
    }
}
