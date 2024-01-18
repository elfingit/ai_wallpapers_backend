<?php

namespace App\Library\Role\Values;

final class CreatedAtValue
{
    public function __construct(private readonly string $created_at)
    {
    }

    public function value(): string
    {
        return $this->created_at;
    }
}
