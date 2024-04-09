<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:02
 */

namespace App\Library\UserBalanceTransaction\Values;

final class BalanceIdValue
{
    public function __construct(private readonly int $id)
    {
    }

    public function value(): int
    {
        return $this->id;
    }
}
