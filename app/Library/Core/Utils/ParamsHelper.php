<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.02.24
 * Time: 12:08
 */

namespace App\Library\Core\Utils;

final class ParamsHelper
{
    public static function cleanSearch(string $search): string
    {
        return str_ireplace([
            '%', "'"
        ], ['', ''], $search);
    }
}
