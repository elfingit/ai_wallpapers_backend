<?php

namespace App\Library\Registration\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('email')]
	#[ValidationRule('required|email|max:255|unique:users,email')]
	public string $email;

	#[RequestParam('password')]
	#[ValidationRule('required|string|min:6|max:25|confirmed')]
	public string $password;

	#[RequestParam('device_id')]
	#[ValidationRule('required|string|uuid')]
	public string $device_id;

    #[RequestParam('agreement')]
    #[ValidationRule('required|accepted')]
    public bool $agree_to_terms;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';
}
