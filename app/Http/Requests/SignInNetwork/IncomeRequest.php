<?php

namespace App\Http\Requests\SignInNetwork;

use App\Http\Requests\AbstractRequest;
use App\Library\Auth\Dto\FacebookDto;
use App\Library\Auth\Dto\GoogleDto;
use App\Library\Auth\Enums\SocialNetworkEnum;

class IncomeRequest extends AbstractRequest
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
        $type = SocialNetworkEnum::tryFrom($this->input('network'));

        return match ($type) {
            SocialNetworkEnum::FACEBOOK => FacebookDto::class,
            SocialNetworkEnum::GOOGLE => GoogleDto::class,
            default => throw new \InvalidArgumentException('Unknown network type'),
        };
    }
}
