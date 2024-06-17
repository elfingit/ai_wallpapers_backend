<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 11:56
 */

namespace App\Library\Billing\Handlers;

use App\Exceptions\DuplicateAppleTransactionException;
use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Library\Billing\Commands\AppleSubscriptionCommand;
use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\Billing\Results\SubscriptionResult;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\AppleSubscription;
use App\Models\SubscriptionScheduler;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\Carbon;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class AppleSubscriptionHandler extends ApplePurchaseHandler
{
    /**
     * @param AppleSubscriptionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $this->logger->info('trying get purchase', [
            'extra' => [
                'product_id' => $command->productId->value(),
                'purchase_token' => $command->purchaseToken->value(),
                'user_id' => $command->userId?->value(),
                'device_id' => $command->deviceId?->value(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        $purchaseData = $this->appleService->getPurchase($command->purchaseToken->value());
        $claims = $purchaseData->claims();


        $transactionCommand = ApplePurchaseTransactionCommand::instanceFromPrimitives(
            $claims->get('transactionId'),
            $claims->get('productId'),
            $claims->get('type'),
            $claims->get('environment'),
            $claims->get('storefront'),
            $claims->get('storefrontId'),
            $claims->get('currency'),
            $claims->get('price'),
            $command->userId?->value(),
            $command->deviceId?->value()
        );

        try {
            $transaction_id = \CommandBus::dispatch($transactionCommand)->getResult();
        } catch (DuplicateAppleTransactionException $e) {
            $this->logger->warning('duplicate transaction', [
                'extra' => [
                    'transaction_id' => $claims->get('transactionId'),
                    'product_id' => $claims->get('productId'),
                    'user_id' => $command->userId?->value(),
                    'device_id' => $command->deviceId?->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new SubscriptionResult(false);
        } catch (\Throwable $e) {
            $this->logger->error('error while saving transaction', [
                'extra' => [
                    'transaction_id' => $claims->get('transactionId'),
                    'product_id' => $claims->get('productId'),
                    'user_id' => $command->userId?->value(),
                    'device_id' => $command->deviceId?->value(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new SubscriptionResult(false);
        }
        $now = Carbon::now();
        $endDate = Carbon::createFromTimestamp($claims->get('expiresDate'));

        $data = [
            'subscription_id' => $claims->get('originalTransactionId'),
            'product_id' => $claims->get('productId'),
            'price' => $claims->get('price'),
            'currency' => $claims->get('currency'),
            'start_date' => $claims->get('purchaseDate'),
            'end_date' => $claims->get('expiresDate'),
            'status' => $now->gt($endDate) ? SubscriptionStatusEnum::ACTIVE : SubscriptionStatusEnum::EXPIRED,
            'account_type' => is_null($command->userId) ? AccountTypeEnum::DEVICE : AccountTypeEnum::USER,
            'account_id' => $command->userId?->value(),
            'account_uuid' => $command->deviceId?->value(),
            'transaction_uuid' => $transaction_id,
        ];

        $subscription = AppleSubscription::where('subscription_id', $claims->get('originalTransactionId'))
            ->first();

        if ($subscription) {
            $subscription->update($data);
            return new SubscriptionResult(true, 0, $subscription->end_date);
        }

        $subscription = AppleSubscription::create($data);

        $amount = 0;

        if ($subscription->status == SubscriptionStatusEnum::ACTIVE) {

            if ($command->userId) {
                $amount = $this->addToUserBalance($command);
            } elseif ($command->deviceId) {
                $amount = $this->addToDeviceBalance($command);
            }

            $this->makeSubscriptionScheduler($subscription);
        }

        return new SubscriptionResult(true, $amount, $subscription->end_date);
    }



    public function isAsync(): bool
    {
        return false;
    }

    private function addToUserBalance(AppleSubscriptionCommand $command): float
    {
        $userBalanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $command->userId->value(),
            $command->productAmount->value(),
            'Apple subscription purchase'
        );

        \CommandBus::dispatch($userBalanceCommand);

        $user = User::find($command->userId->value());

        $this->logger->info('user balance updated', [
            'extra' => [
                'user_id' => $command->userId->value(),
                'balance' => $user->balance->balance,
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        return $user->balance->balance;
    }

    private function addToDeviceBalance(CommandContract|AppleSubscriptionCommand $command): float
    {
        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $command->deviceId->value(),
            $command->productAmount->value(),
            'Apple subscription purchase'
        );

        \CommandBus::dispatch($deviceBalanceCommand);

        $device = UserDevice::find($command->deviceId->value());

        $this->logger->info('device balance updated', [
            'extra' => [
                'device_id' => $command->deviceId->value(),
                'balance' => $device->balance,
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        return $device->balance;
    }

    private function makeSubscriptionScheduler(AppleSubscription $subscription): void
    {
        SubscriptionScheduler::create([
            'subscription_uuid' => $subscription->uuid,
            'market' => MarketTypeEnum::APPLE,
            'next_check_date' => Carbon::parse($subscription->end_date)->subHour(),
            'last_check_date' => Carbon::now(),
        ]);
    }
}
