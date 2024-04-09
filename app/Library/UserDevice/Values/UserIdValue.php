<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.01.24
 * Time: 12:39
 */

namespace App\Library\UserDevice\Values;

final class UserIdValue
{
    public function __construct(private readonly int $user_id)
    {
    }

    public function value(): int
    {
        return $this->user_id;
    }
}
