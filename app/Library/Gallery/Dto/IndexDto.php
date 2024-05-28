<?php

namespace App\Library\Gallery\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class IndexDto
{
	#[RequestParam('id')]
	#[ValidationRule('nullable|integer|max:' . PHP_INT_MAX)]
	public ?int $id;

	#[RequestParam('query')]
	#[ValidationRule('nullable|string|min:2|max:150')]
	public ?string $query;

    #[RequestParam('public')]
    #[ValidationRule('nullable|boolean')]
    public ?bool $is_public = true;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';

    public ?int $user_id = null;
    public ?string $device_uuid = null;

    #[RequestParam('show_by_devices')]
    #[ValidationRule('nullable|boolean')]
    public ?bool $show_by_devices = false;
    #[RequestParam('show_by_user')]
    #[ValidationRule('nullable|boolean')]
    public ?bool $show_by_user = false;
}
