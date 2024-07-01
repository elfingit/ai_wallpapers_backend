<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 18.06.24
 * Time: 09:50
 */

namespace App\Library\SubscriptionScheduler\Commands;

use App\Library\SubscriptionScheduler\Values\SchedulerIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class AppleScheduleSubscriptionCommand extends AbstractCommand
{
    public SchedulerIdValue $schedulerId;

    public static function instanceFromPrimitive(string $scheduler_id): self
    {
        $command = new self();
        $command->schedulerId = new SchedulerIdValue($scheduler_id);

        return $command;
    }
}
