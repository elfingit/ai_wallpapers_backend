<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Gallery\Dto\IndexDto;


class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        $access_to_endpoint = $this->checkAccess(RulesEnum::INDEX_OF_GALLERY);
        $additional_access = true;
        if ($this->has('show_by_devices')) {
            $additional_access = $this->checkAccess(RulesEnum::INDEX_OF_GALLERY_BY_DEVICES);
        }

        if ($this->has('show_by_user')) {
            $additional_access = $this->checkAccess(RulesEnum::INDEX_OF_GALLERY_BY_USERS);
        }

        return $access_to_endpoint && $additional_access;
    }

    protected function getDtoClass(): ?string
    {
        return IndexDto::class;
    }
}
