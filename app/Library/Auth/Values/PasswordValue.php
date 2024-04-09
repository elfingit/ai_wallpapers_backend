<?php

namespace App\Library\Auth\Values;

final class PasswordValue
{
    public function __construct(private readonly string $password)
    {
    }

    public function value(): string
    {
        return $this->password;
    }
}
