<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.06.24
 * Time: 14:40
 */

namespace App\Library\Gallery\Values;

final class StyleValue
{
    private string $style;

    public function __construct(string $style)
    {
        $this->style = $style;
    }

    public function value(): string
    {
        return $this->style;
    }
}
