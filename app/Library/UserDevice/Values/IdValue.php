<?php

namespace App\Library\UserDevice\Values;

final class IdValue
{
    public function __construct(private readonly string $id)
    {
    }

    public function value(): string
    {
        return $this->id;
    }
}
