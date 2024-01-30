<?php

namespace App\Library\Wallpaper\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('prompt')]
	#[ValidationRule('required|string|min:5|max:1500')]
	public string $prompt;
}
