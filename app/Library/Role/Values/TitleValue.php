<?php

namespace App\Library\Role\Values;

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
