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
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Models\User;
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
                'user_id' => $command->userId->value(),
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

        $purchase_data['user_id'] = $command->userId->value();

        $googleTransactionCommand = GooglePurchaseTransactionCommand::instanceFromArray($purchase_data);
        try {
            \CommandBus::dispatch($googleTransactionCommand);
        } catch (DuplicateGoogleOrderException $googleOrderException) {
            $this->logger->error('duplicate order', [
                'extra' => [
                    'message' => $googleOrderException->getMessage(),
                    'purchase_data' => $purchase_data,
                ]
            ]);
            return new PurchaseResult(false);
        } catch (\Throwable $exception) {
            $this->logger->error('error while saving transaction', [
                'extra' => [
                    'message' => $exception->getMessage(),
                    'purchase_data' => $purchase_data,
                ]
            ]);
            return new PurchaseResult(false);
        }

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

    public function isAsync(): bool
    {
        return false;
    }
}
