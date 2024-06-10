<?php

namespace App\Library\Category\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('title')]
	#[ValidationRule('required|string|min:3|max:150')]
	public string $title;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';
}
