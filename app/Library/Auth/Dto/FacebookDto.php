<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 13:06
 */

namespace App\Library\Auth\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class FacebookDto extends AbstractSocialDto
{
    #[RequestParam('email')]
    #[ValidationRule('required|email|max:255')]
    public string $email;

    #[RequestParam('id')]
    #[ValidationRule('required|integer|max:' . PHP_INT_MAX)]
    public string $id;
}
