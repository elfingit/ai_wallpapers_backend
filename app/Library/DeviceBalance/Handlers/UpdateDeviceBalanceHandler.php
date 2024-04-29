<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 17:43
 */

namespace App\Library\DeviceBalance\Handlers;

use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class UpdateDeviceBalanceHandler implements CommandHandlerContract
{
    /**
     * @param UpdateDeviceBalanceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        \DB::beginTransaction();
        $device = UserDevice::lockForUpdate()->find($command->deviceId->value());

        if (!$device) {
            \DB::rollBack();
            return null;
        }

        $device->update([
            'balance' => $device->balance + $command->balanceAmount->value()
        ]);

        \DB::commit();

        $device->refresh();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
