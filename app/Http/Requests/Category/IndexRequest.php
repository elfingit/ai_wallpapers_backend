<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractRequest;
use App\Library\Category\Dto\IndexDto;
use App\Library\Core\Acl\RulesEnum;


class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::LIST_CATEGORY);
    }

    protected function getDtoClass(): ?string
    {
        return IndexDto::class;
    }
}
