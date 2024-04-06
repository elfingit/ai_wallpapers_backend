<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:38
 */

namespace App\Library\Billing\Values;

final class ProductAmountValue
{
    public function __construct(readonly private int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
