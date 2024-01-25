<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Tag\Dto\AddDto;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::ADD_TAG);
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
