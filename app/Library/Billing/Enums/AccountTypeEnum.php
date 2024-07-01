<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 14.06.24
 * Time: 11:46
 */

namespace App\Library\Billing\Enums;

use App\Library\Core\Utils\Traits\EnumValues;

enum AccountTypeEnum: string
{
    use EnumValues;
    case DEVICE = 'device';
    case USER = 'user';
}
