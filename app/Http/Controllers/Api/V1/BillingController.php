<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\PurchaseRequest;
use App\Library\Billing\Commands\GooglePurchaseCommand;
use App\Library\Billing\Enums\MarketTypeEnum;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function store(PurchaseRequest $request, string $type)
    {
        $dto = $request->getDto();
        $dto->user_id = $request->user()->id;

        $market = MarketTypeEnum::tryFrom($type);

        $result = match ($market) {
            MarketTypeEnum::GOOGLE => \CommandBus::dispatch(GooglePurchaseCommand::instanceFromDto($dto)),
            default => throw new \InvalidArgumentException('Unknown market type')
        };
    }
}
