<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 14.06.24
 * Time: 11:58
 */

namespace App\Library\Billing\Enums;

use App\Library\Core\Utils\Traits\EnumValues;

enum SubscriptionStatusEnum: string
{
    use EnumValues;

    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
}
