<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;
use App\Library\Auth\Dto\AddDto;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
