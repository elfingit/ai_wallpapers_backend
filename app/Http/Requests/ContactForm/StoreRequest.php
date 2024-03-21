<?php

namespace App\Http\Requests\ContactForm;

use App\Http\Requests\AbstractRequest;
use App\Library\ContactForm\Dto\AddDto;

class StoreRequest extends AbstractRequest
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
