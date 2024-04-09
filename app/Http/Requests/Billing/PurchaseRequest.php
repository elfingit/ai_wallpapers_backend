<?php

namespace App\Http\Requests\Billing;

use App\Http\Requests\AbstractRequest;
use App\Library\Billing\Dto\GooglePurchaseDto;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Core\Acl\RulesEnum;

class PurchaseRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::BILLING_PURCHASE);
    }

    protected function getDtoClass(): ?string
    {
        $type = MarketTypeEnum::tryFrom($this->route('type'));

        return match($type) {
            MarketTypeEnum::GOOGLE => GooglePurchaseDto::class,
            default => null
        };
    }
}
