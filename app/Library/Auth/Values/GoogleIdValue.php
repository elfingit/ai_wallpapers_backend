<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 13:23
 */

namespace App\Library\Auth\Values;

class GoogleIdValue
{

    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
