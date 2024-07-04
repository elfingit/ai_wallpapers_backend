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
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Models\AppleSubscription;
use App\Models\User;
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

        if (!is_null($command->deviceId)) {
            return $this->restoreForDevice($command, $claims);
        } elseif (!is_null($command->userId)) {
            return $this->restoreForUser($command, $claims);
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

        \DB::beginTransaction();

        $subscription = AppleSubscription::where('subscription_id', $claims->get('originalTransactionId'))
                                        ->lockForUpdate()
                                         ->first();

        if (is_null($subscription)) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $claims->get('originalTransactionId'),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            \DB::rollBack();
            return new SubscriptionResult(false);
        }

        $balance = 0;

        if ($subscription->device) {
            $balance = $subscription->device->balance;
            $this->addToDeviceBalance($subscription->device, 0, 'move to another device while restore purchase');
            $this->addToDeviceBalance($device, $balance, 'move from another device while restore purchase');
        }

        if ($subscription->user) {
            $this->addToDeviceBalance($device, $subscription->user->balance->balance, 'move from user to device while restore purchase');
            $subscription->user->balance->balance = 0;
            $subscription->user->balance->save();
        }

        $subscription->account_uuid = $device->uuid;
        $subscription->account_id = null;
        $subscription->account_type = AccountTypeEnum::DEVICE;
        $subscription->save();
        \DB::commit();
        return new SubscriptionResult(true, $device->balance, $subscription->end_date);
    }

    private function restoreForUser(AppleRestoreCommand $command, $claims): SubscriptionResult
    {
        $user = User::find($command->userId->value());

        if (is_null($user)) {
            $this->logger->warning('user not found', [
                'extra' => [
                    'user_id' => $command->userId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return new SubscriptionResult(false);
        }

        \DB::beginTransaction();

        $subscription = AppleSubscription::where('subscription_id', $claims->get('originalTransactionId'))
                                        ->lockForUpdate()
                                        ->first();

        if (is_null($subscription)) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $claims->get('originalTransactionId'),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            \DB::rollBack();
            return new SubscriptionResult(false);
        }

        $subscription->account_id = $user->id;
        $subscription->account_type = AccountTypeEnum::USER;
        $subscription->account_uuid = null;
        $subscription->save();

        \DB::commit();
        return new SubscriptionResult(true, $user->balance->balance, $subscription->end_date);
    }

    private function addToDeviceBalance(UserDevice $device, float $balance, string $notice = ''): void
    {
        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $device->uuid,
            $balance,
            $notice
        );

        \CommandBus::dispatch($deviceBalanceCommand);

        $device = UserDevice::find($device->uuid);

        $this->logger->info('device balance updated', [
            'extra' => [
                'device_id' => $device->uuid,
                'balance' => $device->balance,
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);
    }
}
