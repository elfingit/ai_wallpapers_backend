<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.04.24
 * Time: 12:40
 */

namespace App\Library\Wallpaper\Contracts;

interface ImageGeneratorServiceContract
{
    public function getImageByPrompt(string $prompt, string $style = null): array | null;
}
