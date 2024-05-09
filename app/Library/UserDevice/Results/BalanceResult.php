<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 14:48
 */

namespace App\Library\UserDevice\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class BalanceResult implements CommandResultContract
{
    public function __construct(readonly private float $balance)
    {
    }

    public function getResult(): float
    {
        return $this->balance;
    }
}
