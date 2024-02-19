<?php

namespace App\Library\User\Handlers;

use App\Library\Core\Utils\ParamsHelper;
use App\Library\User\Results\ListResult;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\User\Commands\IndexUserCommand;

class IndexUserHandler implements CommandHandlerContract
{
    /**
     * @param IndexUserCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $query = User::with(['role', 'balance']);

        if ($command->idValue) {
            $id = ParamsHelper::cleanSearch($command->idValue->value());
            $query->whereRaw('id::text LIKE ?', ["%$id%"]);
        }

        if ($command->emailValue) {
            $email = ParamsHelper::cleanSearch($command->emailValue->value());
            $query->whereRaw('email LIKE ?', ["%$email%"]);
        }

        return new ListResult($query->paginate(50));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
