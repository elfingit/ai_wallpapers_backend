<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.02.24
 * Time: 12:35
 */

namespace App\Library\User\Commands;

use App\Library\User\Values\IdValue;
use App\Library\User\Values\LocaleValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class UserRegisteredCommand extends AbstractCommand
{
    public IdValue $idValue;
    public LocaleValue $localeValue;

    public static function createFromPrimitives(int $id, string $locale): self
    {
        $command = new self();
        $command->idValue = new IdValue($id);
        $command->localeValue = new LocaleValue($locale);
        return $command;
    }
}
