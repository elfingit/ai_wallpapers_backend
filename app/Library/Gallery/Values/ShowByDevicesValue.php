<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.05.24
 * Time: 10:02
 */

namespace App\Library\Gallery\Values;

final class ShowByDevicesValue
{
    public function __construct(readonly private bool $value)
    {
    }


    public function value(): bool
    {
        return $this->value;
    }
}
