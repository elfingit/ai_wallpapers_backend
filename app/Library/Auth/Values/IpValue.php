<?php

namespace App\Library\Auth\Values;

final class IpValue
{
    public function __construct(private readonly string $ip)
    {
    }

    public function value(): string
    {
        return $this->ip;
    }
}
