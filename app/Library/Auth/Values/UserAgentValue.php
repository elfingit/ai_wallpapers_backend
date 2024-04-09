<?php

namespace App\Library\Auth\Values;

final class UserAgentValue
{
    public function __construct(private readonly string $user_agent)
    {
    }

    public function value(): string
    {
        return $this->user_agent;
    }
}
