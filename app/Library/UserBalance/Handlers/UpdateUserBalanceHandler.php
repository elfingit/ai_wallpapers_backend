<?php

namespace App\Library\UserBalance\Handlers;

use App\Library\Core\Logger\LoggerChannel;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use Psr\Log\LoggerInterface;

class UpdateUserBalanceHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::USER_BALANCE);
    }

    /**
     * @param UpdateUserBalanceCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $this->logger->info('trying change user balance', [
            'user_id' => $command->userId->value(),
            'balance_amount' => $command->balanceAmount->value(),
            'file' => __FILE__,
            'line' => __LINE__,
        ]);

        $user = User::findOrFail($command->userId->value());
        \DB::begitTransaction();

        try {
            if (!$user->balance) {
                $this->logger->info('balance not found, creating new', [
                    'user_id' => $command->userId->value(),
                    'balance_amount' => $command->balanceAmount->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]);

                $user->balance()->create([
                    'balance' => $command->balanceAmount->value()
                ]);
            } else {
                $user->balance()->lockForUpdate()->update([
                    'balance' => $user->balance->balance + $command->balanceAmount->value()
                ]);
            }
            $user->balance->refresh();
            \DB::commit();

            $this->logger->info('balance changed', [
                'user_id' => $command->userId->value(),
                'balance_amount' => $command->balanceAmount->value(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]);
        } catch (\Throwable $e) {
            \DB::rollBack();
            $this->logger->error($e->getMessage(), [
                'user_id' => $command->userId->value(),
                'balance_amount' => $command->balanceAmount->value(),
                'trace' => $e->getTraceAsString(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
