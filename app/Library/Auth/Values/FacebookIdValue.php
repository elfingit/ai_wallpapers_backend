<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 13:28
 */

namespace App\Library\Auth\Values;

final class FacebookIdValue
{
    public function __construct(readonly private int $id)
    {
    }

    public function value(): int
    {
        return $this->id;
    }
}
