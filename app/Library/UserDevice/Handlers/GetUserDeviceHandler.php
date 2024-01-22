<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 22.01.24
 * Time: 23:28
 */

namespace App\Library\UserDevice\Handlers;

use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Library\UserDevice\Results\GetResult;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetUserDeviceHandler implements CommandHandlerContract
{
    /**
     * @param GetUserDeviceCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        return new GetResult(UserDevice::findOrFail($command->id->value()));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
