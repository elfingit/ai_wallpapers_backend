<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.02.24
 * Time: 18:18
 */

namespace App\Library\Auth\Values;

use App\Models\User;

final class UserValue
{
    public function __construct(private readonly User $user)
    {

    }

    public function value(): User
    {
        return $this->user;
    }
}
