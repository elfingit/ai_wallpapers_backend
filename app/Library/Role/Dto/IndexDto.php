<?php

namespace App\Library\Role\Dto;

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

	#[RequestParam('created_at')]
	#[ValidationRule('nullable|date|date_format:Y-m-d H:i:s')]
	public ?string $created_at;

	#[RequestParam('updated_at')]
	#[ValidationRule('nullable|date|date_format:Y-m-d H:i:s')]
	public ?string $updated_at;
}
