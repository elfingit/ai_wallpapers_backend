<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\FilePathValue;
use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\RevisedPromptValue;
use App\Library\Gallery\Values\TagsValue;
use App\Library\Gallery\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\FileValue;
use App\Library\Gallery\Values\PromptValue;
use App\Library\Gallery\Dto\AddDto;

class CreateGalleryCommand extends AbstractCommand
{
	public ?FileValue $fileValue = null;
	public PromptValue $promptValue;

    public TagsValue $tagsValue;
    public LocaleValue $localeValue;
    public ?UserIdValue $userIdValue = null;

    public ?FilePathValue $filePathValue = null;

    public ?RevisedPromptValue $revisedPromptValue = null;

    public static function createFromDto(AddDto $dto, int $user_id = null): self
    {
        $command = new self();
		$command->fileValue = new FileValue($dto->file);
		$command->promptValue = new PromptValue($dto->prompt);
        $command->tagsValue = new TagsValue($dto->tags);
        $command->localeValue = new LocaleValue($dto->locale);

        if (!is_null($user_id)) {
            $command->userIdValue = new UserIdValue($user_id);
        }

        return $command;
    }

    public static function createFromPrimitives(
        string $prompt,
        array $tags,
        string $locale,
        ?int $user_id = null,
        ?string $device_id = null,
        string $file_path,
        ?string $revised_prompt = null
    ): self
    {
        $command = new self();

        $command->promptValue = new PromptValue($prompt);
        $command->tagsValue = new TagsValue($tags);
        $command->localeValue = new LocaleValue($locale);
        $command->userIdValue = new UserIdValue($user_id);
        $command->filePathValue = new FilePathValue($file_path);

        if (!is_null($revised_prompt)) {
            $command->revisedPromptValue = new RevisedPromptValue($revised_prompt);
        }

        return $command;
    }
}
