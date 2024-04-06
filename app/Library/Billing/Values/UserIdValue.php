<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 11:51
 */

namespace App\Library\Billing\Values;

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
