<?php

namespace App\Library\Wallpaper\Dto;

use Elfin\LaravelDto\Dto\Attributes\HeaderParam;
use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

final class AddDto
{
	#[RequestParam('prompt')]
	#[ValidationRule('required|string|min:5|max:1500')]
	public string $prompt;

    #[RequestParam('style')]
    #[ValidationRule(
        'required|string|max:150|
        in:3d-model,analog-film,anime,cinematic,comic-book,digital-art,enhance,fantasy-art,isometric,line-art,low-poly,modeling-compound,neon-punk,origami,photographic,pixel-art,tile-texture'
    )]
    public string $style;

    #[HeaderParam('X-App-Locale')]
    public string $locale;
}
