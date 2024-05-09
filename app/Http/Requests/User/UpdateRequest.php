<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Library\User\Dto\UpdateDto;


class UpdateRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        throw new \Exception('You must implement authorize() method');
    }

    protected function getDtoClass(): ?string
    {
        return UpdateDto::class;
    }
}
