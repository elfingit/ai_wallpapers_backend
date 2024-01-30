<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:45
 */

namespace App\Library\Gallery\Commands;

use App\Library\Gallery\Values\LocaleValue;
use App\Library\Gallery\Values\PromptValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetImageByPromptCommand extends AbstractCommand
{
    public PromptValue $promptValue;
    public LocaleValue $localValue;

    public static function instanceFromPrimitives(string $prompt_value, string $locale): self
    {
        $command = new self();
        $command->promptValue = new PromptValue($prompt_value);
        $command->localValue = new LocaleValue($locale);

        return $command;
    }
}
