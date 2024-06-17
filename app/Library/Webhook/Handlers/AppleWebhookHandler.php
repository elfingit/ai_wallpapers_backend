<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:12
 */

namespace App\Library\Webhook\Handlers;

use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\Webhook\Commands\AppleWebhookCommand;
use App\Library\Webhook\Enums\AppleNotificationTypeEnum;
use App\Models\AppleSubscription;
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

        return match ($notificationType) {
            AppleNotificationTypeEnum::SUBSCRIBED => $this->handleSubscribed($info),
            AppleNotificationTypeEnum::EXPIRED => $this->handleExpired($info),
            AppleNotificationTypeEnum::DID_CHANGE_RENEWAL_PREF => $this->changePref($info),
        };
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

        $renewalData = $parser->parse($data['signedRenewalInfo']);

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

        $renewalData = $parser->parse($data['signedRenewalInfo']);

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

        $subscription->status = SubscriptionStatusEnum::EXPIRED;
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
}
