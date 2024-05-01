<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.05.24
 * Time: 09:25
 */

namespace App\Library\Billing\Values;

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
