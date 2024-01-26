<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 03:56
 */

namespace App\Library\Gallery\Values;

final class TagsValue
{
    public function __construct(private readonly array $tags)
    {
    }

    public function value(): array
    {
        return $this->tags;
    }
}
