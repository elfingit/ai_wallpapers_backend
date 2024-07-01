<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractRequest;
use App\Library\Category\Dto\AddDto;
use App\Library\Core\Acl\RulesEnum;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::ADD_CATEGORY);
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
