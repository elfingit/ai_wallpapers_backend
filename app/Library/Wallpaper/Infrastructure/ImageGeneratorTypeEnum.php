<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.04.24
 * Time: 12:42
 */

namespace App\Library\Wallpaper\Infrastructure;

enum ImageGeneratorTypeEnum: string
{
    case DALLE = 'dall-e';
    case STABLE_DIFFUSION = 'stable';
}
