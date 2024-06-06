<?php

namespace App\Library\Category\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class IndexDto
{
	#[RequestParam('id')]
	#[ValidationRule('nullable|integer|max:' . PHP_INT_MAX)]
	public ?int $id;

	#[RequestParam('title')]
	#[ValidationRule('nullable|string|min:3|max:150')]
	public ?string $title;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';
}
