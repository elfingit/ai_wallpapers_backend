<?php

namespace App\Library\Auth\Values;

final class EmailValue
{
    public function __construct(private readonly string $email)
    {
    }

    public function value(): string
    {
        return $this->email;
    }
}
