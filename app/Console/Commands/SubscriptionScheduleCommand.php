<?php

namespace App\Console\Commands;

use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
use App\Library\SubscriptionScheduler\Commands\AppleScheduleSubscriptionCommand;
use App\Library\SubscriptionScheduler\Enums\SchedulerStatusEnum;
use App\Models\SubscriptionScheduler;
use Illuminate\Console\Command;

class SubscriptionScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subs-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SubscriptionScheduler::query()
            ->where('next_check_date', '<=', now())
            ->where('status', SchedulerStatusEnum::WAITING)
            ->get()
            ->each(function (SubscriptionScheduler $scheduler) {
                match ($scheduler->market) {
                    MarketTypeEnum::APPLE => $this->scheduleApple($scheduler),
                    //MarketTypeEnum::GOOGLE => $this->google($scheduler),
                };
            });
    }

    private function scheduleApple(SubscriptionScheduler $scheduler): void
    {
        $command = AppleScheduleSubscriptionCommand::instanceFromPrimitive($scheduler->uuid);
        \CommandBus::dispatch($command);
    }
}
