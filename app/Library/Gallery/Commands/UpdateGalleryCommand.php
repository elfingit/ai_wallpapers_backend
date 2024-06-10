<?php

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\CategoryIdValue;
use App\Library\Gallery\Values\IdValue;
use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\TagsValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Gallery\Values\FileValue;
use App\Library\Gallery\Values\PromptValue;
use App\Library\Gallery\Dto\UpdateDto;

class UpdateGalleryCommand extends AbstractCommand
{
	public PromptValue $promptValue;
    public IdValue $idValue;
    public TagsValue $tagsValue;
    public LocaleValue $localeValue;

    public CategoryIdValue $categoryIdValue;

    public static function createFromDto(UpdateDto $dto, int $pic_id): self
    {
        $command = new self();
		$command->promptValue = new PromptValue($dto->prompt);
        $command->idValue = new IdValue($pic_id);
        $command->tagsValue = new TagsValue($dto->tags);
        $command->localeValue = new LocaleValue($dto->locale);
        $command->categoryIdValue = new CategoryIdValue($dto->category_id);

        return $command;
    }
}
