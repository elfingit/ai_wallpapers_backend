<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAbilitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-abilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update token abilities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating token abilities...');

        $device_abilities = config('abilities.device', []);
        $user_abilities = config('abilities.user', []);

        $sql = 'UPDATE user_device_tokens SET abilities = ?';
        \DB::update($sql, [json_encode($device_abilities)]);

        $sql = 'UPDATE personal_access_tokens SET abilities = ?';
        \DB::update($sql, [json_encode($user_abilities)]);

        $this->info('...done');
    }
}
