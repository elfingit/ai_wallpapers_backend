<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 18.06.24
 * Time: 10:48
 */

namespace App\Library\SubscriptionScheduler\Handlers;

use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\Billing\Services\AppleService;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\SubscriptionScheduler\Commands\AppleScheduleSubscriptionCommand;
use App\Library\SubscriptionScheduler\Enums\SchedulerStatusEnum;
use App\Models\SubscriptionScheduler;
use Carbon\Carbon;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class AppleScheduleSubscriptionHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;
    private AppleService $appleService;
    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::SUBSCRIPTION_SCHEDULER);
        $this->appleService = new AppleService();
    }

    /**
     * @param AppleScheduleSubscriptionCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        \DB::beginTransaction();

        $scheduler = SubscriptionScheduler::query()
            ->lockForUpdate()
            ->where('uuid', $command->schedulerId->value())
            ->first();

        if ($scheduler === null) {
            $this->logger->error('Scheduler not found', [
                'extra' => [
                    'scheduler_id' => $command->schedulerId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            \DB::rollBack();
            return null;
        }

        $scheduler->status = SchedulerStatusEnum::IN_PROGRESS;
        $scheduler->save();

        $this->logger->info('trying check subscription', [
            'extra' => [
                'subscription' => $scheduler->appleSubscription,
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);

        $subscription = $this->appleService->getSubscription($scheduler->appleSubscription->subscription_id);

        if ($subscription === null) {
            $this->logger->error('Subscription not found', [
                'extra' => [
                    'scheduler_id' => $command->schedulerId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            $scheduler->status = SchedulerStatusEnum::BROKE_ON_ERROR;
            $scheduler->save();
            \DB::commit();
            return null;
        }

        $renewalInfo = $subscription[1]?->claims();

        if (!$renewalInfo) {
            $this->logger->error('Renewal info not found', [
                'extra' => [
                    'scheduler_id' => $command->schedulerId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            $scheduler->status = SchedulerStatusEnum::BROKE_ON_ERROR;
            $scheduler->save();
            \DB::commit();
            return null;
        }

        if ($renewalInfo->get('autoRenewStatus') === 0) {
            $this->logger->info('Subscription is not auto renew', [
                'extra' => [
                    'scheduler_id' => $command->schedulerId->value(),
                    'file' => __FILE__,
                    'line' => __LINE__,
                ]
            ]);
            $scheduler->appleSubscription->status = SubscriptionStatusEnum::EXPIRED;
            $scheduler->appleSubscription->save();
            $scheduler->delete();
            \DB::commit();
            return null;
        }

        $scheduler->appleSubscription->status = SubscriptionStatusEnum::ACTIVE;
        $scheduler->appleSubscription->save();
        $scheduler->next_check_date = Carbon::createFromTimestamp($renewalInfo->get('renewalDate') / 1000);
        $scheduler->last_check_date = Carbon::now();
        $scheduler->status = SchedulerStatusEnum::WAITING;
        $scheduler->save();

        \DB::commit();

        $this->logger->info('Subscription data', [
            'extra' => [
                'data' => $renewalInfo->all(),
                'file' => __FILE__,
                'line' => __LINE__,
            ]
        ]);



        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
