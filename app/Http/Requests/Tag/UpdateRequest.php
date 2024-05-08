<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\AbstractRequest;
use App\Library\Tag\Dto\UpdateDto;


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
