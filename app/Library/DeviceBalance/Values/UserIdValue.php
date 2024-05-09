<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.05.24
 * Time: 10:02
 */

namespace App\Library\DeviceBalance\Values;

final class UserIdValue
{
    public function __construct(readonly private int $id)
    {
    }

    public function value(): int
    {
        return $this->id;
    }
}
