<?php

namespace App\Library\UserDevice\Handlers;

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
            return new CreateResult($device);
        }

        $device = UserDevice::create([
            'uuid' => $command->idValue->value(),
            'ip_address' => $command->ipValue->value(),
            'user_agent' => $command->userAgentValue->value(),
            'user_id' => $command->userIdValue->value(),
        ]);

        return new CreateResult($device);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
