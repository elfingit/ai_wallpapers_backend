<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 8.05.24
 * Time: 07:33
 */

namespace App\Library\PersonalData\Values;

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
