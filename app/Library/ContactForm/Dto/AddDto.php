<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 07:36
 */

namespace App\Library\ContactForm\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
    #[RequestParam('name')]
    #[ValidationRule('required|string|max:150')]
    public string $name;

    #[RequestParam('email')]
    #[ValidationRule('required|email|max:150')]
    public string $email;

    #[RequestParam('message')]
    #[ValidationRule('required|string|max:1500')]
    public string $message;
}
