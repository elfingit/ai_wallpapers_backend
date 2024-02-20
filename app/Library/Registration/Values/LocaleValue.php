<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.02.24
 * Time: 12:49
 */

namespace App\Library\Registration\Values;

final class LocaleValue
{
    public function __construct(private readonly string $locale)
    {
    }

    public function value(): string
    {
        return $this->locale;
    }
}
