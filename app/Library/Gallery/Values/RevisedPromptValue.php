<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 12:52
 */

namespace App\Library\Gallery\Values;

final class RevisedPromptValue
{
    public function __construct(private readonly string $prompt) {}

    public function value(): string
    {
        return $this->prompt;
    }
}
