<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 09:02
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\SyncDeviceSubscriptionCommand;
use App\Library\Billing\Enums\AccountTypeEnum;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class SyncDeviceSubscriptionHandler implements CommandHandlerContract
{
    /**
     * @param SyncDeviceSubscriptionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $device = UserDevice::find($command->deviceId->value());

        $subscription = $device->subscription;

        if (!$subscription) {
            return null;
        }

        $subscription->account_type = AccountTypeEnum::USER;
        $subscription->account_id = $command->userId->value();
        $subscription->account_uuid = null;
        $subscription->save();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
