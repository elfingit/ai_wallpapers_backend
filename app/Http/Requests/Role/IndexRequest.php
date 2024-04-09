<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\AbstractRequest;
use App\Library\Role\Dto\IndexDto;


class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        throw new \Exception('You must implement authorize() method');
    }

    protected function getDtoClass(): ?string
    {
        return IndexDto::class;
    }
}
