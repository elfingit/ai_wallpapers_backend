<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 08:49
 */

namespace App\Library\UserBalance\Values;

final class BalanceAmountValue
{
    public function __construct(private readonly float $amount)
    {
    }

    public function value(): float
    {
        return $this->amount;
    }
}