<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 11:42
 */

namespace App\Library\Billing\Enums;

enum MarketTypeEnum: string
{
    case GOOGLE = 'google';
    case APPLE = 'apple';
}
