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

final class GoogleDto extends AbstractSocialDto
{
    #[RequestParam('email')]
    #[ValidationRule('required|email|max:255')]
    public string $email;

    #[RequestParam('id')]
    #[ValidationRule('required|string|max:150')]
    public string $id;
}
