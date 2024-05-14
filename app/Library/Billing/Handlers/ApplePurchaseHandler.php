<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 14:59
 */

namespace App\Library\Billing\Handlers;

use App\Exceptions\DuplicateAppleTransactionException;
use App\Library\Billing\Commands\ApplePurchaseCommand;
use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Library\Billing\Results\PurchaseResult;
use App\Library\Billing\Services\AppleService;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\User;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class ApplePurchaseHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;
    private AppleService $appleService;

    public function __construct()
    {
        $this->appleService = new AppleService();
        $this->logger = \LoggerService::getChannel(LoggerChannel::APPLE_PURCHASE);
    }
    /**
     * @param ApplePurchaseCommand $command
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

        if (is_null($purchaseData)) {
            $this->logger->warning('purchase not found', [
                'extra' => [
                    'product_id' => $command->productId->value(),
                    'purchase_token' => $command->purchaseToken->value(),
                    'user_id' => $command->userId?->value(),
                    'device_id' => $command->deviceId?->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new PurchaseResult(false);
        }

        $claims = $purchaseData->claims();

        $this->logger->info('purchase found', [
            'extra' => [
                'transaction_id' => $claims->get('transactionId'),
                'product_id' => $claims->get('productId'),
                'user_id' => $command->userId?->value(),
                'device_id' => $command->deviceId?->value(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

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
            \CommandBus::dispatch($transactionCommand);
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

            return new PurchaseResult(false);
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

            return new PurchaseResult(false);
        }

        if (!is_null($command->userId)) {
            return $this->userPurchase($command);
        } elseif (!is_null($command->deviceId)) {
            return $this->devicePurchase($command);
        }

        return new PurchaseResult(false);
    }

    public function isAsync(): bool
    {
        return false;
    }

    private function userPurchase(ApplePurchaseCommand $command): ?CommandResultContract
    {
        $userBalanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $command->userId->value(),
            $command->productAmount->value(),
            'Apple purchase'
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

        return new PurchaseResult(true, $user->balance->balance);
    }

    private function devicePurchase(ApplePurchaseCommand $command): ?CommandResultContract
    {
        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $command->deviceId->value(),
            $command->productAmount->value(),
            'Apple purchase'
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

        return new PurchaseResult(true, $device->balance, 'need_account_purchase');
    }
}
