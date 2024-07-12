<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 10:56
 */

namespace App\Library\Billing\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class DebtResult implements CommandResultContract
{
    public function __construct(private readonly float $debt)
    {
    }

    public function getResult(): float
    {
        return $this->debt;
    }
}
