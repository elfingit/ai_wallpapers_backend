<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 18.06.24
 * Time: 09:41
 */

namespace App\Library\SubscriptionScheduler\Enums;

use App\Library\Core\Utils\Traits\EnumValues;

enum SchedulerStatusEnum: string
{
    use EnumValues;

    case IN_PROGRESS = 'in_progress';
    case WAITING = 'waiting';
    case BROKE_ON_ERROR = 'broke_on_error';
}
