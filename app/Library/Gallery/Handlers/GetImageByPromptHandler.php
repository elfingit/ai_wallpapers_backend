<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:51
 */

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Results\GalleryResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetImageByPromptHandler implements CommandHandlerContract
{
    private bool $use_default_img;
    private int $default_img_id;

    public function __construct()
    {
        $this->use_default_img = config('ai.use_default_img');
        $this->default_img_id = config('ai.default_img');
    }


    /**
     * @param GetImageByPromptCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        if ($this->use_default_img) {
            $gallery = Gallery::find($this->default_img_id);
            if ($gallery) {
                sleep(3);
                return new GalleryResult($gallery);
            }
        }

        $gallery = Gallery::query()
                          ->where('prompt', $command->promptValue->value())
                          ->where('locale', $command->localValue->value())
                          ->orderBy('id', 'desc')
                          ->first();

        if ($gallery) {
            return new GalleryResult($gallery);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
