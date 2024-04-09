<?php

namespace App\Console\Commands;

use App\Library\Registration\Commands\CreateRegistrationCommand;
use Illuminate\Console\Command;

class AddAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin to system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Enter admin email');
        $password = $this->ask('Enter admin password');
        $command = CreateRegistrationCommand::createFromPrimitive($email, $password, 'admin');
        $result = \CommandBus::dispatch($command);
        $this->info('Admin ID: ' . $result->getResult()->id);
    }
}
