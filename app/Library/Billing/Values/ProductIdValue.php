<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 11:49
 */

namespace App\Library\Billing\Values;

final class ProductIdValue
{
    public function __construct(readonly private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
