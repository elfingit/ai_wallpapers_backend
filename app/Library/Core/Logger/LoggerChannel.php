<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 31.01.24
 * Time: 10:28
 */

namespace App\Library\Core\Logger;

enum LoggerChannel: string
{
    case OPEN_AI = 'openai';
    case USER_BALANCE = 'user_balance';

    case HTTP_REQUEST = 'http_request';
}
