<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 14:33
 */

namespace App\Library\Wallpaper\Values;

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
