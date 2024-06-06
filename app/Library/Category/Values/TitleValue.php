<?php

namespace App\Library\Category\Values;

final class TitleValue
{
    public function __construct(private readonly string $title)
    {
    }

    public function value(): string
    {
        return $this->title;
    }
}
