<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 14.05.24
 * Time: 12:07
 */

namespace App\Library\SearchQuery\Values;

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
