<?php

namespace App\Console\Commands;

use App\Library\Gallery\Commands\NotifyUserFreeGalleryCommand;
use App\Models\Gallery;
use Illuminate\Console\Command;

class NotifyNewFreeWallpapersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-new-wallpapers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to users about new free wallpapers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gallery_count = Gallery::query()
            ->whereNull('user_id')
            ->whereNull('device_uuid')
            ->whereBetween('created_at', [now()->subDay(), now()])
            ->count();

        if ($gallery_count > 0) {
            \CommandBus::dispatch(new NotifyUserFreeGalleryCommand());
        }
    }
}
