<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.06.24
 * Time: 08:23
 */

namespace App\Library\Billing\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ApplePurchaseTransactionResult implements CommandResultContract
{
    public function __construct(private readonly string $transaction_id)
    {
    }

    public function getResult(): string
    {
        return $this->transaction_id;
    }
}
