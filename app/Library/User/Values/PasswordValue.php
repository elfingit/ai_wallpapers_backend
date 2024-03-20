<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 15:15
 */

namespace App\Library\User\Values;

final class PasswordValue
{
    public function __construct(private readonly string $password)
    {
    }

    public function value(): string
    {
        return $this->password;
    }
}
