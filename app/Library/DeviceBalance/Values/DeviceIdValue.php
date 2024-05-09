<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 17:39
 */

namespace App\Library\DeviceBalance\Values;

final class DeviceIdValue
{
    public function __construct(readonly private string $device_id)
    {
    }

    public function value(): string
    {
        return $this->device_id;
    }
}
