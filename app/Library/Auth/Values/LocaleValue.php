<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 15:33
 */

namespace App\Library\Auth\Values;

final class LocaleValue
{
    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
