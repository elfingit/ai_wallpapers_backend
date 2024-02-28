<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.02.24
 * Time: 09:13
 */

namespace App\Library\Core\Utils;

final class Utils
{
    public static function buildImageUrl(int $id, string $type): string
    {
        return config('images_service.host') . "/api/v1/gallery/{$id}/{$type}";
    }
}
