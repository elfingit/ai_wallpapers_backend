<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.01.24
 * Time: 12:47
 */

namespace App\Library\Registration\Results;

use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class RegistrationResult implements CommandResultContract
{
    public function __construct(private readonly User $user)
    {
    }
    public function getResult(): User
    {
        return $this->user;
    }
}
