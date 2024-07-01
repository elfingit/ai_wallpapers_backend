<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 09:52
 */

namespace App\Library\User\Results;

use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ProfileResult implements CommandResultContract
{
    public function __construct(private readonly User $user)
    {
    }

    public function getResult(): array
    {
        return [
            'balance' => $this->user->balance->balance,
            'subscription_end' => $this->user->subscription?->end_date ?? 0,
        ];
    }
}
