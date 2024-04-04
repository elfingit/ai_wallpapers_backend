<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 09:36
 */

namespace App\Library\PersonalData\Values;

final class LocalValue
{

    public function __construct(readonly private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
