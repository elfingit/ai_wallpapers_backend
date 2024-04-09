<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:39
 */

namespace App\Library\Wallpaper\Values;

class UserIdValue
{
    public function __construct(private readonly int $user_id)
    {
    }

    public function value(): int
    {
        return $this->user_id;
    }
}
