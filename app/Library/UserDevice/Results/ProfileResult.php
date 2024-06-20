<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.06.24
 * Time: 11:16
 */

namespace App\Library\UserDevice\Results;

use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ProfileResult implements CommandResultContract
{
    public function __construct(private readonly UserDevice $device)
    {
    }


    public function getResult(): array
    {
        return [
            'balance' => $this->device->balance,
            'subscription_end' => $this->device->subscription?->end_date ?? 0,
        ];
    }
}
