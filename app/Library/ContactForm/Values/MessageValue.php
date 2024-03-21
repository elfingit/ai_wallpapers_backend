<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 07:39
 */

namespace App\Library\ContactForm\Values;

class MessageValue
{
    public function __construct(private readonly string $message)
    {
    }

    public function value(): string
    {
        return $this->message;
    }
}
