<?php

namespace App\Library\Tag\Values;

final class IdValue
{
    public function __construct(private readonly int $id)
    {
    }

    public function value(): int
    {
        return $this->id;
    }
}
