<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:20
 */

namespace App\Library\Category\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;

final class MainDto
{
    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';
}
