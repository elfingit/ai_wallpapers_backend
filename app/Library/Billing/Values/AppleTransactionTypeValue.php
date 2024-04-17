<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 08:11
 */

namespace App\Library\Billing\Values;

final class AppleTransactionTypeValue
{
    public function __construct(readonly private string $value)
    {}

    public function value(): string
    {
        return $this->value;
    }
}
