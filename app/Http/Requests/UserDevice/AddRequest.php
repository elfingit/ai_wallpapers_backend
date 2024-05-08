<?php

namespace App\Http\Requests\UserDevice;

use App\Http\Requests\AbstractRequest;
use App\Library\UserDevice\Dto\AddDto;

class AddRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
