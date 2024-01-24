<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\FileValue;
use App\Library\Gallery\Values\PromptValue;
use App\Library\Gallery\Dto\AddDto;

class CreateGalleryCommand extends AbstractCommand
{
	public FileValue $fileValue;
	public PromptValue $promptValue;

    public ?UserIdValue $userIdValue = null;

    public static function createFromDto(AddDto $dto, int $user_id = null): self
    {
        $command = new self();
		$command->fileValue = new FileValue($dto->file);
		$command->promptValue = new PromptValue($dto->prompt);

        if (!is_null($user_id)) {
            $command->userIdValue = new UserIdValue($user_id);
        }

        return $command;
    }
}
