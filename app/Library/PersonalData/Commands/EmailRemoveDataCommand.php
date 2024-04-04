<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 09:19
 */

namespace App\Library\PersonalData\Commands;

use App\Library\PersonalData\Values\EmailValue;
use App\Library\PersonalData\Values\LocalValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class EmailRemoveDataCommand extends AbstractCommand
{
    public EmailValue $emailValue;
    public LocalValue $localValue;
    static public function instanceFromPrimitive(string $email): self
    {
        $command = new self();
        $command->emailValue = new EmailValue($email);
        $command->localValue = new LocalValue(\App::getLocale());
        return $command;
    }
}
