<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 18.06.24
 * Time: 09:50
 */

namespace App\Library\SubscriptionScheduler\Values;

final class SchedulerIdValue
{
    public function __construct(private readonly string $scheduler_id)
    {
    }

    public function value(): string
    {
        return $this->scheduler_id;
    }
}
