<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.06.24
 * Time: 14:04
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\AppleRestoreCommand;
use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Results\SubscriptionResult;
use App\Library\Billing\Services\AppleService;
use App\Library\Core\Logger\LoggerChannel;
use App\Models\AppleSubscription;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class AppleRestoreHandler implements CommandHandlerContract
{
    protected LoggerInterface $logger;
    protected AppleService $appleService;

    public function __construct()
    {
        $this->appleService = new AppleService();
        $this->logger = \LoggerService::getChannel(LoggerChannel::APPLE_PURCHASE);
    }
    /**
     * @param AppleRestoreCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        list($subscriptionData, $renewalData) = $this->appleService->getSubscription($command->purchaseToken->value());
        $claims = $subscriptionData->claims();
        $renewClaims = $renewalData->claims();

        if (!is_null($command->deviceId)) {
            return $this->restoreForDevice($command, $claims);
        } elseif (!is_null($command->userId)) {
            return $this->restoreForUser($command, $claims, $renewClaims);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }

    private function restoreForDevice(AppleRestoreCommand $command, $claims): SubscriptionResult
    {
        $device = UserDevice::where('uuid', $command->deviceId->value())
                            ->first();

        if (is_null($device)) {
            $this->logger->warning('device not found', [
                'extra' => [
                    'device_id' => $command->deviceId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return new SubscriptionResult(false);
        }

        if ($device->subscription) {
            $device->subscription->account_uuid = null;
            $device->subscription->save();
        }

        $subscription = AppleSubscription::where('subscription_id', $claims->get('originalTransactionId'))
                                         ->first();

        if (is_null($subscription)) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $claims->get('originalTransactionId'),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return new SubscriptionResult(false);
        }

        $subscription->account_uuid = $device->uuid;
        $subscription->account_type = AccountTypeEnum::DEVICE;
        $subscription->save();

        return new SubscriptionResult(true, $device->balance, $subscription->end_date);
    }
}
