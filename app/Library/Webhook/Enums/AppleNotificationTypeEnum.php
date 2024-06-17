<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:29
 */

namespace App\Library\Webhook\Enums;

enum AppleNotificationTypeEnum: string
{
    case SUBSCRIBED = 'SUBSCRIBED';
    case EXPIRED = 'EXPIRED';
    case DID_CHANGE_RENEWAL_PREF = 'DID_CHANGE_RENEWAL_PREF';
    case DID_RENEW = 'DID_RENEW';
}
