<?php

namespace App\Library\UserDevice\Values;

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
