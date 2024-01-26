<?php

namespace App\Library\Gallery\Handlers;

use App\Library\Gallery\Results\IndexResult;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Gallery\Commands\IndexGalleryCommand;

class IndexGalleryHandler implements CommandHandlerContract
{
    /**
     * @param IndexGalleryCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $query = Gallery::with('tags');
        $locale = $command->localeValue->value();
        $query->where('locale', $locale);

        if ($command->idValue) {
            $query->where('id', $command->idValue->value());
        }

        if ($command->queryValue) {
            $tags = explode(' ', $command->queryValue->value());
            $tags = array_filter($tags, fn($tag) => !empty($tag) || strlen($tag) > 2);
            $query->whereHas('tags', fn($q) => $q->whereIn("title->{$locale}", $tags));
        }

        if ($command->isPublicValue->value()) {
            $query->where(function ($query) use ($command) {
                $query->whereNull('user_id');
                $query->orWhere('user_id', $command->userIdValue->value());
            });
        } else {
            $query->where('user_id', $command->userIdValue->value());
        }

        $query->orderBy('id', 'desc');

        return new IndexResult($query->paginate(15));
    }

    public function isAsync(): bool
    {
        return false;
    }
}
