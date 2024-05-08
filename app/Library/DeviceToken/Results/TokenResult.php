<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.04.24
 * Time: 14:37
 */

namespace App\Library\DeviceToken\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class TokenResult implements CommandResultContract
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getResult(): string
    {
        return $this->token;
    }
}
