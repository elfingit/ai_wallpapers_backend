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

        $sql = 'SELECT u.id FROM roles r INNER JOIN users u ON u.role_id = r.id
         WHERE r.title_slug = \'admin\'';
        $admin_ids = \DB::select($sql);
        $admin_ids = array_map(function ($item) {
            return $item->id;
        }, $admin_ids);


        $sql = 'UPDATE personal_access_tokens SET abilities = ? WHERE tokenable_id NOT IN (' . implode(',', $admin_ids) . ')';
        \DB::update($sql, [json_encode($user_abilities)]);

        $this->info('...done');
    }
}
