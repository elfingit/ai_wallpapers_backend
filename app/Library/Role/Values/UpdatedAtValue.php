<?php

namespace App\Library\Role\Values;

final class UpdatedAtValue
{
    public function __construct(private readonly string $updated_at)
    {
    }

    public function value(): string
    {
        return $this->updated_at;
    }
}
