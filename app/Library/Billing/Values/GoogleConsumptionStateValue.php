<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:18
 */

namespace App\Library\Billing\Values;

final class GoogleConsumptionStateValue
{
    public function __construct(private readonly int $state)
    {
    }

    public function value(): int
    {
        return $this->state;
    }
}
