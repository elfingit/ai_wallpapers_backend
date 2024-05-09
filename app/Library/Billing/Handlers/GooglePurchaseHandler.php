<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 12:00
 */

namespace App\Library\Billing\Handlers;

use App\Exceptions\DuplicateGoogleOrderException;
use App\GlobalServices\GoogleService;
use App\Library\Billing\Commands\GooglePurchaseCommand;
use App\Library\Billing\Commands\GooglePurchaseTransactionCommand;
use App\Library\Billing\Results\PurchaseResult;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\User;
use App\Models\UserDevice;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class GooglePurchaseHandler implements CommandHandlerContract
{
    private GoogleService $googleService;
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->googleService = new GoogleService();
        $this->logger = \LoggerService::getChannel(LoggerChannel::GOOGLE_PURCHASE);
    }

    /**
     * @param GooglePurchaseCommand $command
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
            ]
        ]);

        $purchase_data = $this->googleService->getPurchase(
            $command->productId->value(),
            $command->purchaseToken->value()
        );

        if (is_null($purchase_data)) {
            $this->logger->warning('purchase not found', [
                'extra' => [
                    'product_id' => $command->productId->value(),
                    'purchase_token' => $command->purchaseToken->value(),
                    'user_id' => $command->userId->value(),
                ]
            ]);
            return new PurchaseResult(false);
        }

        $this->logger->info('purchase found', [
            'extra' => [
                'purchase_data' => $purchase_data,
            ]
        ]);

        if ($purchase_data['acknowledgementState'] !== 1) {
            return new PurchaseResult(false);
        }

        try {
            if (!is_null($command->userId)) {
                return $this->userPurchase($command, $purchase_data);
            } elseif (!is_null($command->deviceId)) {
                return $this->devicePurchase($command, $purchase_data);
            }
        } catch (DuplicateGoogleOrderException $googleOrderException) {
            $this->logger->error('duplicate order', [
                'extra' => [
                    'message' => $googleOrderException->getMessage(),
                    'purchase_data' => $purchase_data,
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return new PurchaseResult(false);
        } catch (\Throwable $exception) {
            $this->logger->error('error while acknowledge purchase', [
                'extra' => [
                    'message' => $exception->getMessage(),
                    'purchase_data' => $purchase_data,
                    'trace' => $exception->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return new PurchaseResult(false);
        }

        return new PurchaseResult(false);
    }

    public function isAsync(): bool
    {
        return false;
    }

    private function userPurchase(GooglePurchaseCommand $command, array $purchase_data): PurchaseResult
    {
        $purchase_data['user_id'] = $command->userId->value();

        $googleTransactionCommand = GooglePurchaseTransactionCommand::instanceFromArray($purchase_data);

        \CommandBus::dispatch($googleTransactionCommand);

        $userBalanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $command->userId->value(),
            $command->productAmount->value(),
            'Google purchase'
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

    private function devicePurchase(GooglePurchaseCommand $command, array $purchase_data): PurchaseResult
    {
        $purchase_data['device_id'] = $command->deviceId->value();

        $googleTransactionCommand = GooglePurchaseTransactionCommand::instanceFromArray($purchase_data);

        \CommandBus::dispatch($googleTransactionCommand);

        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $command->deviceId->value(),
            $command->productAmount->value(),
            'Google purchase'
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
