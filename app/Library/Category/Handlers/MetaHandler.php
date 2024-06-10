<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 11:53
 */

namespace App\Library\Category\Handlers;

use App\Library\Category\Results\MetaResult;
use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class MetaHandler implements CommandHandlerContract
{
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        return new MetaResult(
            Category::get()->pluck('title', 'id')->toArray()
        );
    }

    public function isAsync(): bool
    {
        return false;
    }
}
