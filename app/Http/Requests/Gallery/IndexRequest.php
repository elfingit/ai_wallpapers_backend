<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Gallery\Dto\IndexDto;


class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::INDEX_OF_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return IndexDto::class;
    }
}
