<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class BalanceRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::MAIN_BALANCE);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
