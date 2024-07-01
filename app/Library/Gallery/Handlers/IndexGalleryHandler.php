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
        $query = Gallery::with('tags:title');

        if ($command->idValue) {
            $query->where('id', $command->idValue->value());
        }

        if ($command->categoryIdValue) {
            $query->where('category_id', $command->categoryIdValue->value());
        }

        if ($command->isPublicValue->value()) {
            $query->whereNull('user_id');
            $query->whereNull('device_uuid');
        } else if (
            $command->showByDevicesValue->value() == false
            && $command->showByUserValue->value() == false
        ) {
            if ($command->deviceIdValue) {
                $query->where('device_uuid', $command->deviceIdValue->value());
            } else if ($command->userIdValue) {
                $query->where('user_id', $command->userIdValue->value());
            }
        }

        $this->showByFlags($command, $query);

        $query->orderBy('id', 'desc');

        return new IndexResult($query->paginate(20));
    }

    public function isAsync(): bool
    {
        return false;
    }

    private function showByFlags(IndexGalleryCommand $command, $query): void
    {
        if (is_null($command->userIdValue)) {
            return;
        }

        if ($command->showByUserValue->value() === true) {
            $query->whereNotNull('user_id');
        }

        if ($command->showByDevicesValue->value() === true) {
            $query->whereNotNull('device_uuid');
        }
    }
}
