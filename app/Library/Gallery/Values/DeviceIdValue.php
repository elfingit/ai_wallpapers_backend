<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.04.24
 * Time: 12:35
 */

namespace App\Library\Gallery\Values;

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
