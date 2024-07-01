<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.06.24
 * Time: 15:37
 */

namespace App\Library\Gallery\Values;

final class IsFeaturedValue
{
    public function __construct(private readonly bool $value)
    {
    }

    public function value(): bool
    {
        return $this->value;
    }
}
