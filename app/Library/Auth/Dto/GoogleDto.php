<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 13:22
 */

namespace App\Library\Auth\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

class GoogleDto
{
    #[RequestParam('email')]
    #[ValidationRule('required|email|max:255')]
    public string $email;

    #[RequestParam('id')]
    #[ValidationRule('required|integer|max:' . PHP_INT_MAX)]
    public string $id;

    #[RequestParam('device_id')]
    #[ValidationRule('required|string|max:255|uuid')]
    public string $device_id;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';

    public string $ip;
    public string $user_agent;
}
