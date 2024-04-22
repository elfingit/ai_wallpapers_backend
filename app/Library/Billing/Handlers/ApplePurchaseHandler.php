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
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\User;
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
                'user_id' => $command->userId->value(),
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
                    'user_id' => $command->userId->value(),
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
                'user_id' => $command->userId->value(),
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
            $command->userId->value()
        );

        try {
            \CommandBus::dispatch($transactionCommand);
        } catch (DuplicateAppleTransactionException $e) {
            $this->logger->warning('duplicate transaction', [
                'extra' => [
                    'transaction_id' => $claims->get('transactionId'),
                    'product_id' => $claims->get('productId'),
                    'user_id' => $command->userId->value(),
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
                    'user_id' => $command->userId->value(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return new PurchaseResult(false);
        }

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

    public function isAsync(): bool
    {
        return false;
    }
}
