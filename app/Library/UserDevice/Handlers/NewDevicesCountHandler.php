<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 11:05
 */

namespace App\Library\UserDevice\Handlers;

use App\Library\UserDevice\Results\DevicesCountResult;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class NewDevicesCountHandler implements CommandHandlerContract
{
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $startDate = now()->subDay()->startOfDay();
        $endDate = now()->subDay()->endOfDay();

        $count = UserDevice::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return new DevicesCountResult($count);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
