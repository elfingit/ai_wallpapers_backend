<?php

namespace App\Library\Tag\Handlers;

use App\Library\Tag\Results\CreateTagResult;
use App\Models\Tag;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Tag\Commands\CreateTagCommand;

class CreateTagHandler implements CommandHandlerContract
{
    /**
     * @param CreateTagCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $ids = [];
        $locale = $command->localeValue->value();
        foreach ($command->titleValue->value() as $title) {
            $tag_id = Tag::where("title->{$locale}", $title)->first()?->id;

            if (is_null($tag_id)) {
                $tag = Tag::create([
                    "title" => [
                        $locale => $title
                    ]
                ]);
                $tag_id = $tag->id;
            }

            $ids[] = $tag_id;
        }

        return new CreateTagResult($ids);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
