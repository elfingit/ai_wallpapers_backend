<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 14:09
 */

namespace App\Library\User\Commands;

use App\Library\User\Values\IdValue;
use App\Library\User\Values\LocaleValue;
use App\Library\User\Values\PasswordValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class UserRegisteredFromSocialNetworkCommand extends AbstractCommand
{
    public IdValue $userId;
    public LocaleValue $locale;
    public PasswordValue $password;

    public static function createFromPrimitives(int $userId, string $locale, string $password): self
    {
        $command = new self();
        $command->userId = new IdValue($userId);
        $command->locale = new LocaleValue($locale);
        $command->password = new PasswordValue($password);

        return $command;
    }
}
