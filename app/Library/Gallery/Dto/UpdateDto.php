<?php

namespace App\Library\Gallery\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationArrayRule;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class UpdateDto
{
    #[RequestParam('prompt')]
	#[ValidationRule('required|string|min:5|max:1500')]
	public string $prompt;

    #[RequestParam('tag')]
    #[ValidationArrayRule('required|string|min:2|max:20')]
    public array $tags;

    #[RequestParam('locale')]
    #[ValidationRule('required|string|size:2')]
    public string $locale;

    #[RequestParam('category')]
    #[ValidationRule('required|integer|exists:categories,id')]
    public int $category_id;
}
