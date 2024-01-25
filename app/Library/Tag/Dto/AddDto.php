<?php

namespace App\Library\Tag\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('title')]
	#[ValidationRule('required|string|min:3|max:150')]
	public string $title;
}
