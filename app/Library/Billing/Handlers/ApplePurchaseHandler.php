<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 14:59
 */

namespace App\Library\Billing\Handlers;

use App\Library\Billing\Commands\ApplePurchaseCommand;
use App\Library\Billing\Results\PurchaseResult;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ApplePurchaseHandler implements CommandHandlerContract
{
    /**
     * @param ApplePurchaseCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        return new PurchaseResult(false);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
