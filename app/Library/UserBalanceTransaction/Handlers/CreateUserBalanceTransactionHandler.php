<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:07
 */

namespace App\Library\UserBalanceTransaction\Handlers;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreateUserBalanceTransactionHandler implements CommandHandlerContract
{
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        // TODO: Implement __invoke() method.
    }

    public function isAsync(): bool
    {
        return true;
    }
}
