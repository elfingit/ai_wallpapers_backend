<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 12:00
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\GooglePurchaseCommand;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GooglePurchaseHandler implements CommandHandlerContract
{
    /**
     * @param GooglePurchaseCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        // TODO: Implement __invoke() method.
    }

    public function isAsync(): bool
    {
        return false;
    }
}
