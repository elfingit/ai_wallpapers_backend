<?php

namespace App\Library\Category\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class UpdateDto
{
	#[RequestParam('title')]
	#[ValidationRule('required|string|min:3|max:150')]
	public string $title;
}
