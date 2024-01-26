<?php

namespace App\Library\Tag\Values;

final class TitlesValue
{
    public function __construct(private readonly array $titles)
    {
    }

    public function value(): array
    {
        return $this->titles;
    }
}
