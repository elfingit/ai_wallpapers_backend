<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 7.05.24
 * Time: 12:39
 */

namespace App\Library\Wallpaper\Values;

final class StyleValue
{
    public function __construct(readonly private string $style)
    {
    }

    public function value(): string
    {
        return $this->style;
    }
}
