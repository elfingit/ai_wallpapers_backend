<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 11:41
 */

namespace App\Http\Requests\Billing;

use App\Http\Requests\AbstractRequest;
use App\Library\Billing\Dto\ApplePurchaseDto;
use App\Library\Billing\Dto\AppleSubscriptionDto;
use App\Library\Billing\Dto\GooglePurchaseDto;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Core\Acl\RulesEnum;

class SubscriptionRequest extends AbstractRequest
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
            MarketTypeEnum::APPLE => AppleSubscriptionDto::class,
            default => null
        };
    }
}
