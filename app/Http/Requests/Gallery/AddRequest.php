<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Gallery\Dto\AddDto;
use Illuminate\Validation\Validator;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::ADD_FILE_TO_GALLERY);
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
            if (count($this->input('tag')) > 10) {
                $validator->errors()->add('tag', __('You can add max 10 tags'));
            }
        });
    }
}
