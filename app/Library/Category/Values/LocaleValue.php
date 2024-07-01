<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 03:57
 */

namespace App\Library\Category\Values;

final class LocaleValue
{
    public function __construct(private readonly string $locale) {}

    public function value(): string
    {
        return $this->locale;
    }
}
