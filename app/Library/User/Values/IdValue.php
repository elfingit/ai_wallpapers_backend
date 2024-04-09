<?php

namespace App\Library\User\Values;

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
