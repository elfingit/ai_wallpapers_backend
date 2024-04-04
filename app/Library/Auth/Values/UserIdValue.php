<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 11:09
 */

namespace App\Library\Auth\Values;

final class UserIdValue
{
    public function __construct(readonly private int $user_id)
    {
    }

    public function value(): int
    {
        return $this->user_id;
    }
}
