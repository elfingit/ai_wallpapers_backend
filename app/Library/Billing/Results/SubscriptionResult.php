<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.06.24
 * Time: 08:27
 */

namespace App\Library\Billing\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class SubscriptionResult implements CommandResultContract
{
    public function __construct(
        private readonly bool $success,
        private readonly int $amount = 0,
        private readonly int $subscription_end_date = 0,
    ) {
    }

    public function getResult(): array
    {
        return [
            'success' => $this->success,
            'amount' => $this->amount,
            'subscription_end_date' => $this->subscription_end_date,
        ];
    }
}
