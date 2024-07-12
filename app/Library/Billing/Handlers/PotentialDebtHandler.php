<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 10:53
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Results\DebtResult;
use App\Models\UserBalance;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class PotentialDebtHandler implements CommandHandlerContract
{
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $devices_sum = UserDevice::query()->sum('balance');
        $users_sum = UserBalance::query()->sum('balance');

        return new DebtResult($devices_sum + $users_sum);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
