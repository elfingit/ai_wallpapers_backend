<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 16:00
 */

namespace App\Library\Billing\Services\Apple;

enum AppleEnvironment: string
{
    case SANDBOX = 'sandbox';
    case PRODUCTION = 'production';
}
