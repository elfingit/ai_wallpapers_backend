<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 10:28
 */

namespace App\Library\Auth\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;

abstract class AbstractSocialDto
{
    public string $device_id;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';

    public string $ip;
    public string $user_agent;
}
