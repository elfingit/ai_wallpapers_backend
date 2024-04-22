<?php

namespace App\Console\Commands;

use App\Library\Gallery\Commands\GalleryReplicateCommand;
use App\Models\Gallery;
use Illuminate\Console\Command;

class ReplicateFreeImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:replicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replicate free images for all locales.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sql = 'SELECT g1.id FROM galleries g1
             WHERE (SELECT COUNT(*) FROM galleries g2 WHERE g2.prompt = g1.prompt) = 1
               AND user_id IS NULL;';
        $records = \DB::select($sql);

        foreach ($records as $record) {
            $command = GalleryReplicateCommand::createFromPrimitives($record->id);
            \CommandBus::dispatch($command);
        }
    }
}
