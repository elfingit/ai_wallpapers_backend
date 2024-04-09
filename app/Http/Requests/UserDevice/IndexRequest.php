<?php

namespace App\Http\Requests\UserDevice;

use App\Http\Requests\AbstractRequest;
use App\Library\UserDevice\Dto\IndexDto;


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
