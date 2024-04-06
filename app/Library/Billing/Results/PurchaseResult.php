<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:42
 */

namespace App\Library\Billing\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

final class PurchaseResult implements CommandResultContract
{
    public function __construct(readonly private bool $success, readonly private int $amount = 0)
    {
    }

    public function getResult(): array
    {
        return [
            'success' => $this->success,
            'amount' => $this->amount,
        ];
    }
}
