<?php

namespace App\Library\UserDevice\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class IndexDto
{
	#[RequestParam('id')]
	#[ValidationRule('nullable|uuid')]
	public ?string $id;

	#[RequestParam('ip')]
	#[ValidationRule('nullable|string|min:15|max:15')]
	public ?string $ip;

	#[RequestParam('user_agent')]
	#[ValidationRule('nullable|string|min:15|max:1024')]
	public ?string $user_agent;
}
