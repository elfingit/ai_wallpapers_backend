<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:07
 */

namespace App\Library\Webhook\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AppleDto
{
    #[RequestParam('signedPayload')]
    #[ValidationRule('required|string|max:65535')]
    public string $signedPayload;
}
