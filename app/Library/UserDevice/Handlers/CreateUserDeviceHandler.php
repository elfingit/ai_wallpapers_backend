<?php

namespace App\Library\UserDevice\Handlers;

use App\Library\DeviceBalance\Command\SyncDeviceUserBalanceCommand;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\Gallery\Commands\SyncUserDeviceCommand;
use App\Library\UserDevice\Results\CreateResult;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\UserDevice\Commands\CreateUserDeviceCommand;

class CreateUserDeviceHandler implements CommandHandlerContract
{
    /**
     * @param CreateUserDeviceCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::where('uuid', $command->idValue->value())
                    ->first();
        if ($device) {
            if (!is_null($command->userIdValue) && is_null($device->user_id)) {
                $device->user_id = $command->userIdValue->value();
                $device->save();

                $syncCommand = SyncUserDeviceCommand::instanceFromPrimitives(
                    $device->uuid,
                    $command->userIdValue->value()
                );

                \CommandBus::dispatch($syncCommand);

                $balanceSyncCommand = SyncDeviceUserBalanceCommand::instanceFromPrimitives(
                    $device->uuid,
                    $command->userIdValue->value()
                );

                \CommandBus::dispatch($balanceSyncCommand);
            }

            return new CreateResult($device);
        }

        $data = [
            'uuid' => $command->idValue->value(),
            'ip_address' => $command->ipValue->value(),
            'user_agent' => $command->userAgentValue->value(),
            'balance' => 0,
        ];

        if (!is_null($command->userIdValue)) {
            $data['user_id'] = $command->userIdValue->value();
        }

        $device = UserDevice::create($data);

        return new CreateResult($device);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
