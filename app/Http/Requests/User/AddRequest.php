<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Library\User\Dto\AddDto;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        throw new \Exception('You must implement authorize() method');
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
