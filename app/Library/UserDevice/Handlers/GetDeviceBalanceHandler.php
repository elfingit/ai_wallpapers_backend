<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 14:41
 */

namespace App\Library\UserDevice\Handlers;

use App\Library\UserDevice\Commands\GetDeviceBalanceCommand;
use App\Library\UserDevice\Results\BalanceResult;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetDeviceBalanceHandler implements CommandHandlerContract
{
    /**
     * @param GetDeviceBalanceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::where('uuid', $command->deviceIdValue->value())
            ->first();

        if ($device === null) {
            return new BalanceResult(0);
        }

        return new BalanceResult($device->balance);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
