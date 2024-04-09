<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 10:18
 */

namespace App\Library\PersonalData\Commands;

use App\Library\PersonalData\Values\TokenValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class RemoveDataCommand extends AbstractCommand
{
    public TokenValue $token;

    static public function instanceFromPrimitive(string $token): self
    {
        $command = new self();
        $command->token = new TokenValue($token);
        return $command;
    }
}
