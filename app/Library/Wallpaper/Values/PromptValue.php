<?php

namespace App\Library\Wallpaper\Values;

final class PromptValue
{
    public function __construct(private readonly string $prompt)
    {
    }

    public function value(): string
    {
        return $this->prompt;
    }
}
