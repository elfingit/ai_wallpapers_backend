<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 10:58
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\UserPicturesMakePublicCommand;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class UserPicturesMakePublicHandler implements CommandHandlerContract
{
    /**
     * @param UserPicturesMakePublicCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        Gallery::where('user_id', $command->userIdValue->value())
            ->update(['user_id' => null]);

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
