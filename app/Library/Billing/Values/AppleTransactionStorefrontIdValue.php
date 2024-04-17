<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 08:14
 */

namespace App\Library\Billing\Values;

final class AppleTransactionStorefrontIdValue
{
    public function __construct(readonly private string $value)
    {}

    public function value(): string
    {
        return $this->value;
    }
}
