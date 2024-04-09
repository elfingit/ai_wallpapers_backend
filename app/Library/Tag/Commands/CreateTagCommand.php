<?php

namespace App\Library\Tag\Commands;

use App\Library\Tag\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Tag\Values\TitlesValue;

class CreateTagCommand extends AbstractCommand
{
	public TitlesValue $titleValue;
    public LocaleValue $localeValue;

    public static function createFromPrimitives(array $titles, string $locale): self
    {
        $command = new self();
		$command->titleValue = new TitlesValue($titles);
        $command->localeValue = new LocaleValue($locale);

        return $command;
    }
}
