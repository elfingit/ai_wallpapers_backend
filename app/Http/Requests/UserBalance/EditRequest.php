<?php

namespace App\Http\Requests\UserBalance;

use App\Http\Requests\AbstractRequest;


class EditRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        throw new \Exception('You must implement authorize() method');
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
