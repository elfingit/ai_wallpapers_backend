<?php

namespace App\Console\Commands;

use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use Illuminate\Console\Command;

class AddToUserBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user_balance {user_id} {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add requests to user balance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $amount = $this->argument('amount');

        $command = UpdateUserBalanceCommand::instanceFromPrimitives($userId, $amount);

        \CommandBus::dispatch($command);
    }
}
