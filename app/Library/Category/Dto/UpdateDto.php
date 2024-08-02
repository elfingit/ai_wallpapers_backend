<?php

namespace App\Library\Category\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationArrayRule;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class UpdateDto
{
	#[RequestParam('title')]
	#[ValidationArrayRule(['required', 'string', 'max:150'])]
	public array $titles;

    #[RequestParam('locale')]
    #[ValidationArrayRule(['required', 'string', 'max:2', 'in:en,ru,pl,fr,hu,ro,uk,tr'])]
    public array $locales;

    public int $id;
}
