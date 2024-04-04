<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 10:18
 */

namespace App\Library\PersonalData\Values;

final class TokenValue
{
    public function __construct(readonly private string $token)
    {
    }

    public function value(): string
    {
        return $this->token;
    }
}
