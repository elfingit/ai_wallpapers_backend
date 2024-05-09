<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 09:55
 */

namespace App\Library\DeviceBalance\Values;

final class NoticeValue
{
    public function __construct(private readonly string $notice)
    {
    }

    public function value(): string
    {
        return $this->notice;
    }
}
