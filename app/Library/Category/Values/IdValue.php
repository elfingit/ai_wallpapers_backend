<?php

namespace App\Library\Category\Values;

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
