<?php

namespace App\Http\Requests\Registration;

use App\Http\Requests\AbstractRequest;
use App\Library\Registration\Dto\AddDto;


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
