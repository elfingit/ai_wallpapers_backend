<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.04.24
 * Time: 14:17
 */

namespace App\Library\DeviceToken\Handlers;

use App\Library\DeviceToken\Commands\CreateDeviceTokenCommand;
use App\Library\DeviceToken\Results\TokenResult;
use App\Models\UserDevice;
use Carbon\Carbon;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreateDeviceTokenHandler implements CommandHandlerContract
{
    /**
     * @param CreateDeviceTokenCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::where('uuid', $command->deviceId->value())->first();

        if (!$device) {
            return null;
        }

        $randomStr = \Str::random(40);
        $token = $randomStr . '.' . hash('crc32b', $randomStr);

        $tokenModel = $device->tokens()->create([
            'token' => $token,
            'abilities' => config('abilities.device', []),
            'expires_at' => Carbon::now()->addDays(30 * 3),
        ]);

        return new TokenResult($tokenModel->id . '|' . hash('sha256', $token));
    }

    public function isAsync(): bool
    {
        return false;
    }

}
