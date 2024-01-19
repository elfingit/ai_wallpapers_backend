<?php

namespace App\Library\Role\Handlers;

use App\Library\Role\Results\CreatedRoleResult;
use App\Models\Role;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Role\Commands\CreateRoleCommand;

class CreateRoleHandler implements CommandHandlerContract
{
    /**
     * @param CreateRoleCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $role = Role::create([
            'title' => $command->titleValue->value(),
            'title_slug' => \Str::slug($command->titleValue->value())
        ]);

        return new CreatedRoleResult($role);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
