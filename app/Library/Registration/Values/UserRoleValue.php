<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.01.24
 * Time: 15:55
 */

namespace App\Library\Registration\Values;

final class UserRoleValue
{
    public function __construct(private readonly string $role)
    {
    }

    public function value(): string
    {
        return $this->role;
    }
}
