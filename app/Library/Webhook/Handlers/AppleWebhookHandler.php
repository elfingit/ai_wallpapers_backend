<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:12
 */

namespace App\Library\Webhook\Handlers;

use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\SubscriptionScheduler\Enums\SchedulerStatusEnum;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Library\Webhook\Commands\AppleWebhookCommand;
use App\Library\Webhook\Enums\AppleNotificationTypeEnum;
use App\Models\ApplePurchaseTransaction;
use App\Models\AppleSubscription;
use App\Models\SubscriptionScheduler;
use Carbon\Carbon;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\DataSet;
use Lcobucci\JWT\Token\Parser;
use Psr\Log\LoggerInterface;

class AppleWebhookHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;
    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::APPLE_PURCHASE);
    }


    /**
     * @param AppleWebhookCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $parser = new Parser(new JoseEncoder());
        $info = $parser->parse($command->appleSignedPayloadValue->value())->claims();

        if (!$info->has('notificationType')) {
            $this->logger->warning('notificationType not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        //originalTransactionId == subscription id
        $notificationType = AppleNotificationTypeEnum::tryFrom($info->get('notificationType'));

        match ($notificationType) {
            AppleNotificationTypeEnum::SUBSCRIBED => $this->handleSubscribed($info),
            AppleNotificationTypeEnum::EXPIRED => $this->handleExpired($info),
            AppleNotificationTypeEnum::DID_CHANGE_RENEWAL_PREF => $this->changePref($info),
            AppleNotificationTypeEnum::DID_RENEW => $this->renewSubscription($info),
        };

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }

    private function handleSubscribed(DataSet $info)
    {
        $data = $info->get('data');
        if (!isset($data['signedTransactionInfo'])) {
            $this->logger->warning('signedTransactionInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        $parser = new Parser(new JoseEncoder());
        $purchaseData = $parser->parse($data['signedTransactionInfo']);

        //Transaction info
        $claims = $purchaseData->claims();

        if (!isset($data['signedRenewalInfo'])) {
            $this->logger->warning('signedRenewalInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return null;
        }

        $subscription_id = $claims->get('originalTransactionId');

        $subscription = AppleSubscription::where('subscription_id', $subscription_id)->first();


        if (!$subscription) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $subscription_id,
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        if ($subscription->status == SubscriptionStatusEnum::ACTIVE) {
            $this->logger->info('subscription already active', [
                'extra' => [
                    'subscription_id' => $subscription_id,
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }
    }

    private function handleExpired(DataSet $info)
    {
        $data = $info->get('data');

        if (!isset($data['signedTransactionInfo'])) {
            $this->logger->warning('signedTransactionInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        $parser = new Parser(new JoseEncoder());
        $purchaseData = $parser->parse($data['signedTransactionInfo']);

        //Transaction info
        $claims = $purchaseData->claims();

        if (!isset($data['signedRenewalInfo'])) {
            $this->logger->warning('signedRenewalInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return null;
        }

        $subscription_id = $claims->get('originalTransactionId');

        $subscription = AppleSubscription::where('subscription_id', $subscription_id)->first();


        if (!$subscription) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $subscription_id,
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        if ($subscription->status == SubscriptionStatusEnum::EXPIRED) {
            $this->logger->info('subscription already expired', [
                'extra' => [
                    'subscription_id' => $subscription_id,
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        $subscription->status = SubscriptionStatusEnum::EXPIRED;
        $subscription->scheduler->delete();
        $subscription->save();

        return null;
    }

    private function changePref(DataSet $info)
    {
        $data = $info->get('data');

        if (!isset($data['signedTransactionInfo'])) {
            $this->logger->warning('signedTransactionInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        $parser = new Parser(new JoseEncoder());
        $purchaseData = $parser->parse($data['signedTransactionInfo']);

        //Transaction info
        $claims = $purchaseData->claims();

        $this->logger->info('change renewal pref', [
            'extra' => [
                'claims' => $claims->all(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        return null;
    }

    private function renewSubscription(DataSet $info)
    {
        $data = $info->get('data');

        if (!isset($data['signedTransactionInfo'])) {
            $this->logger->warning('signedTransactionInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        if (!isset($data['signedRenewalInfo'])) {
            $this->logger->warning('signedRenewalInfo not found', [
                'extra' => [
                    'claims' => $info->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return null;
        }

        $parser = new Parser(new JoseEncoder());
        $purchaseData = $parser->parse($data['signedTransactionInfo']);
        $renewalInfo = $parser->parse($data['signedRenewalInfo']);

        //Transaction info
        $purchaseClaims = $purchaseData->claims();
        $renewalClaims = $renewalInfo->claims();

        if ($renewalClaims->get('autoRenewStatus') == 0) {
            $this->logger->info('subscription canceled', [
                'extra' => [
                    'claims' => $renewalClaims->all(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return null;
        }

        $subscription = AppleSubscription::where('subscription_id', $purchaseClaims->get('originalTransactionId'))
                                         ->first();

        if (!$subscription) {
            $this->logger->warning('subscription not found', [
                'extra' => [
                    'subscription_id' => $purchaseClaims->get('originalTransactionId'),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            return null;
        }

        $transaction = ApplePurchaseTransaction::where('transaction_id', $purchaseClaims->get('transactionId'))
                                ->first();

        if ($transaction) {
            $this->logger->warning('transaction already exists', [
                'extra' => [
                    'transaction_id' => $purchaseClaims->get('transactionId'),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);

            return null;
        }

        $transactionCommand = ApplePurchaseTransactionCommand::instanceFromPrimitives(
            $purchaseClaims->get('transactionId'),
            $purchaseClaims->get('productId'),
            $purchaseClaims->get('type'),
            $purchaseClaims->get('environment'),
            $purchaseClaims->get('storefront'),
            $purchaseClaims->get('storefrontId'),
            $purchaseClaims->get('currency'),
            $purchaseClaims->get('price'),
            $subscription->account_id,
            $subscription->account_uuid
        );

        \CommandBus::dispatch($transactionCommand);

        $subscription->product_id = $purchaseClaims->get('productId');
        $subscription->status = SubscriptionStatusEnum::ACTIVE;
        $subscription->end_date = $renewalClaims->get('renewalDate');
        $subscription->save();

        $scheduler = $subscription->scheduler;

        if (!$scheduler) {
            SubscriptionScheduler::create([
                'subscription_uuid' => $subscription->uuid,
                'market' => MarketTypeEnum::APPLE,
                'next_check_date' => Carbon::createFromTimestamp($renewalClaims->get('renewalDate') / 1000)
                                                ->subHour(),
                'last_check_date' => Carbon::now(),
                'status' => SchedulerStatusEnum::WAITING,
            ]);
        } else {
            $scheduler->next_check_date = Carbon::createFromTimestamp($renewalClaims->get('renewalDate') / 1000)
                                                ->subHour();
            $scheduler->last_check_date = Carbon::now();
            $scheduler->status = SchedulerStatusEnum::WAITING;
            $scheduler->save();
        }

        $this->updateBalance($subscription);

        return null;
    }

    private function updateBalance(AppleSubscription $subscription): void
    {
        match ($subscription->account_type) {
            AccountTypeEnum::USER => $this->addToUserBalance($subscription),
            AccountTypeEnum::DEVICE => $this->addToDeviceBalance($subscription),
        };
    }

    private function addToUserBalance(AppleSubscription $subscription): void
    {
        $userBalanceCommand = UpdateUserBalanceCommand::instanceFromPrimitives(
            $subscription->account_id,
            config('products.subscriptions.' . $subscription->product_id) ?? 0,
            'Apple subscription renewal'
        );

        \CommandBus::dispatch($userBalanceCommand);
    }

    private function addToDeviceBalance(AppleSubscription $subscription): void
    {
        $deviceBalanceCommand = UpdateDeviceBalanceCommand::instanceFromPrimitives(
            $subscription->account_uuid,
            config('products.subscriptions.' . $subscription->product_id) ?? 0,
            'Apple subscription renewal'
        );

        \CommandBus::dispatch($deviceBalanceCommand);
    }
}
