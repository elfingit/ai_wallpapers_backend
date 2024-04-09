<?php

namespace App\Library\Auth\Values;

final class DeviceIdValue
{
    public function __construct(private readonly string $device_id)
    {
    }

    public function value(): string
    {
        return $this->device_id;
    }
}
