<?php

namespace App\Library\User\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class IndexDto
{
	#[RequestParam('id')]
	#[ValidationRule('nullable|integer|max:' . PHP_INT_MAX)]
	public ?int $id;

	#[RequestParam('email')]
	#[ValidationRule('nullable|string|min:5|max:100')]
	public ?string $email;
}
