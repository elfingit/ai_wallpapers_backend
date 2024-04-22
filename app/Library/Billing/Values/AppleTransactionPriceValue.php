<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 08:15
 */

namespace App\Library\Billing\Values;

final class AppleTransactionPriceValue
{
    public function __construct(readonly private int $value)
    {}

    public function value(): int
    {
        return $this->value;
    }
}
