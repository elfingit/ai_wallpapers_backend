<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 07:39
 */

namespace App\Library\ContactForm\Commands;

use App\Library\ContactForm\Dto\AddDto;
use App\Library\ContactForm\Values\EmailValue;
use App\Library\ContactForm\Values\MessageValue;
use App\Library\ContactForm\Values\NameValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class SendMessageCommand extends AbstractCommand
{
    public EmailValue $email;
    public NameValue $name;
    public MessageValue $message;

    public static function instanceFromDto(AddDto $dto): self
    {
        $command = new self();
        $command->email = new EmailValue($dto->email);
        $command->name = new NameValue($dto->name);
        $command->message = new MessageValue($dto->message);

        return $command;
    }
}
