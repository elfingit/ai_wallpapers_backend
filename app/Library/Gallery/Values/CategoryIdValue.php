<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 11:43
 */

namespace App\Library\Gallery\Values;

final class CategoryIdValue
{
    public function __construct(readonly private int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
