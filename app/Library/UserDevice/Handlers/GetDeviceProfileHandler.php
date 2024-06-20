<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.06.24
 * Time: 11:04
 */

namespace App\Library\UserDevice\Handlers;

use App\Library\UserDevice\Commands\GetDeviceProfileCommand;
use App\Library\UserDevice\Results\ProfileResult;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetDeviceProfileHandler implements CommandHandlerContract
{
    /**
     * @param GetDeviceProfileCommand $command
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::find($command->deviceId->value());

        return new ProfileResult($device);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
