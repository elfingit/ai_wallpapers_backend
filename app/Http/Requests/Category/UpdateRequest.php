<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractRequest;
use App\Library\Category\Dto\UpdateDto;
use App\Library\Core\Acl\RulesEnum;


class UpdateRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::UPDATE_CATEGORY);
    }

    protected function getDtoClass(): ?string
    {
        return UpdateDto::class;
    }
}
