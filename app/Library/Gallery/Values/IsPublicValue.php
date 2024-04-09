<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 11:28
 */

namespace App\Library\Gallery\Values;

final class IsPublicValue
{
    public function __construct(private readonly bool $is_public) {}

    public function value(): bool
    {
        return $this->is_public;
    }
}
