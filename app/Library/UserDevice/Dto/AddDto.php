<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.04.24
 * Time: 14:56
 */

namespace App\Library\UserDevice\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
    #[RequestParam('device_id')]
    #[ValidationRule('required|string|uuid')]
    public string $device_id;
}
