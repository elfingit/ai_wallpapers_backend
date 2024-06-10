<?php

namespace App\Library\Gallery\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationArrayRule;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;
use Illuminate\Http\UploadedFile;

final class AddDto
{
	#[RequestParam('file')]
	#[ValidationRule('required|max:10240|mimes:png|extensions:png')]
	public UploadedFile $file;

	#[RequestParam('prompt')]
	#[ValidationRule('required|string|min:5|max:1500')]
	public string $prompt;

    #[RequestParam('tag')]
    #[ValidationArrayRule('required|string|min:2|max:20')]
    public array $tags;

    #[RequestParam('category')]
    #[ValidationRule('required|integer|exists:categories,id')]
    public int $category_id;

    #[HeaderParam('X-App-Locale')]
    public string $locale = 'en';
}
