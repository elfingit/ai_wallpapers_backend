<?php

namespace App\Library\Auth\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('email')]
	#[ValidationRule('required|email|max:255')]
	public string $email;

	#[RequestParam('password')]
	#[ValidationRule('required|string|min:6|max:25')]
	public string $password;

	#[RequestParam('device_id')]
	#[ValidationRule('required|string|max:255|uuid')]
	public string $device_id;
}
