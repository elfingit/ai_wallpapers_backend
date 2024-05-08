<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 10:01
 */

namespace App\Library\DeviceBalance\Handlers;

use App\Library\DeviceBalance\Command\SyncDeviceUserBalanceCommand;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class SyncDeviceUserBalanceHandler implements CommandHandlerContract
{
    /**
     * @param SyncDeviceUserBalanceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::where('uuid', $command->deviceId->value())
            ->first();

        $balance = $device->balance;

        $userBalanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $command->userId->value(),
            $balance,
            'Device balance sync'
        );

        \CommandBus::dispatch($userBalanceCommand);

        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $command->deviceId->value(),
            $balance * -1,
            'User balance sync'
        );

        \CommandBus::dispatch($deviceBalanceCommand);

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
