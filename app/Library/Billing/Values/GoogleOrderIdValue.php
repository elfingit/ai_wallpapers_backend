<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:17
 */

namespace App\Library\Billing\Values;

final class GoogleOrderIdValue
{
    public function __construct(readonly private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
