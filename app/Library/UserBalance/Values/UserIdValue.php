<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 08:44
 */

namespace App\Library\UserBalance\Values;

final class UserIdValue
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
