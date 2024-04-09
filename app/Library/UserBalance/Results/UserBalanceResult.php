<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:58
 */

namespace App\Library\UserBalance\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class UserBalanceResult implements CommandResultContract
{
    public function __construct(readonly private float $balance)
    {
    }

    public function getResult(): float
    {
        return $this->balance;
    }
}
