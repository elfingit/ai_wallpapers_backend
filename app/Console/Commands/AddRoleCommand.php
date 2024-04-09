<?php

namespace App\Console\Commands;

use App\Library\Role\Commands\CreateRoleCommand;
use Illuminate\Console\Command;

class AddRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user role and return role ID';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $role_name = $this->ask('Enter role name');
        $command = CreateRoleCommand::createFromPrimitive($role_name);
        $result = \CommandBus::dispatch($command);
        $this->info('Role ID: ' . $result->getResult()->value());
    }
}
