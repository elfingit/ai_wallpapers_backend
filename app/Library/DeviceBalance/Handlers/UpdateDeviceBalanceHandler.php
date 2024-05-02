<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 17:43
 */

namespace App\Library\DeviceBalance\Handlers;

use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Models\DeviceBalanceTransaction;
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
            throw new \Exception('Device not found');
        }

        $device->update([
            'balance' => $device->balance + $command->balanceAmount->value()
        ]);

        DeviceBalanceTransaction::create([
            'device_id' => $device->uuid,
            'amount' => $command->balanceAmount->value(),
            'notice' => $command->notice?->value()
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
