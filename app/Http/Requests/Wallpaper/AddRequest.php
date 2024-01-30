<?php

namespace App\Http\Requests\Wallpaper;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Wallpaper\Dto\AddDto;
use Illuminate\Validation\Validator;

class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(RulesEnum::MAKE_WALLPAPER);
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }

    public function withValidator(Validator $validator): void
    {
        if ($validator->fails()) {
            return;
        }

        $validator->after(function ($validator) {
            $prompts = explode(' ', $this->input('prompt'));
            $prompts = array_filter($prompts, fn($prompt) => strlen($prompt) > 2);
            if (count($prompts) < 5) {
                $validator->errors()->add('prompt', __('Prompt must contain at least 5 words'));
            }
        });
    }
}
