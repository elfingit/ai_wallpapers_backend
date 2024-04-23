<?php

namespace App\Console\Commands;

use App\Library\Gallery\Commands\PictureUploadedCommand;
use App\Library\Gallery\Handlers\GalleryReplicateHandler;
use App\Library\Gallery\Handlers\NotifyUserFreeGalleryHandler;
use App\Models\Gallery;
use Illuminate\Console\Command;

class FillThumbnailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:thb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If some picture has no thumbnail, create it.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Gallery::whereNull('thumbnail_path')->get()->each(function ($gallery) {
            $command = PictureUploadedCommand::createFromPrimitives($gallery->id);
            \CommandBus::dispatch($command, [
                GalleryReplicateHandler::class,
                NotifyUserFreeGalleryHandler::class
            ]);
        });
    }
}
