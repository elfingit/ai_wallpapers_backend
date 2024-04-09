<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 13:15
 */

namespace App\Library\Auth\Enums;

enum SocialNetworkEnum: string
{
    case FACEBOOK = 'facebook';
    case GOOGLE = 'google';
}
