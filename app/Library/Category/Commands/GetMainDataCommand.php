<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:18
 */

namespace App\Library\Category\Commands;

use App\Library\Category\Dto\MainDto;
use App\Library\Category\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GetMainDataCommand extends AbstractCommand
{
    public LocaleValue $localValue;
    static public function instanceFromDto(MainDto $dto): self
    {
        $command = new self();
        $command->localValue = new LocaleValue($dto->locale);
        return $command;
    }
}
