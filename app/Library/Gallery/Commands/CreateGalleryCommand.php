<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\CategoryIdValue;
use App\Library\Gallery\Values\DeviceIdValue;
use App\Library\Gallery\Values\FilePathValue;
use App\Library\Gallery\Values\IsFeaturedValue;
use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\RevisedPromptValue;
use App\Library\Gallery\Values\StyleValue;
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
    public CategoryIdValue $categoryIdValue;
    public ?UserIdValue $userIdValue = null;
    public ?DeviceIdValue $deviceIdValue = null;

    public ?FilePathValue $filePathValue = null;

    public ?RevisedPromptValue $revisedPromptValue = null;

    public ?StyleValue $styleValue = null;

    public ?IsFeaturedValue $isFeaturedValue = null;

    public static function createFromDto(AddDto $dto, int $user_id = null): self
    {
        $command = new self();
		$command->fileValue = new FileValue($dto->file);
		$command->promptValue = new PromptValue($dto->prompt);
        $command->tagsValue = new TagsValue($dto->tags);
        $command->localeValue = new LocaleValue($dto->locale);
        $command->categoryIdValue = new CategoryIdValue($dto->category_id);
        $command->isFeaturedValue = new IsFeaturedValue($dto->is_featured);

        if (!is_null($user_id)) {
            $command->userIdValue = new UserIdValue($user_id);
        }

        return $command;
    }

    public static function createFromPrimitives(
        string $prompt,
        array $tags,
        string $locale,
        string $file_path,
        ?int $user_id = null,
        ?string $device_id = null,
        ?string $revised_prompt = null,
        ?string $style = null
    ): self
    {
        $command = new self();

        $command->promptValue = new PromptValue($prompt);
        $command->tagsValue = new TagsValue($tags);
        $command->localeValue = new LocaleValue($locale);

        if (!is_null($user_id)) {
            $command->userIdValue = new UserIdValue($user_id);
        }

        if (!is_null($device_id)) {
            $command->deviceIdValue = new DeviceIdValue($device_id);
        }

        $command->filePathValue = new FilePathValue($file_path);

        if (!is_null($revised_prompt)) {
            $command->revisedPromptValue = new RevisedPromptValue($revised_prompt);
        }

        if (!is_null($style)) {
            $command->styleValue = new StyleValue($style);
        }

        return $command;
    }
}
