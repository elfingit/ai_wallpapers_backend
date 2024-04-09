<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\User\Dto\IndexDto;


class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return$this->checkAccess(RulesEnum::USER_LIST);
    }

    protected function getDtoClass(): ?string
    {
        return IndexDto::class;
    }
}
