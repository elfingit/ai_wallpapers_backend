<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\PurchaseRequest;
use App\Http\Resources\User\PurchaseResultResource;
use App\Library\Billing\Commands\ApplePurchaseCommand;
use App\Library\Billing\Commands\GooglePurchaseCommand;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Core\Logger\LoggerChannel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingController extends Controller
{
    public function store(PurchaseRequest $request, string $type): JsonResource
    {
        $dto = $request->getDto();
        $dto->user_id = $request->user()->id;
        $dto->product_amount = config('products.' . $dto->product_id);

        $market = MarketTypeEnum::tryFrom($type);

        \LoggerService::getChannel(LoggerChannel::HTTP_REQUEST)->info('Purchase request', [
            'request' => $request->all(),
        ]);

        $result = match ($market) {
            MarketTypeEnum::GOOGLE => \CommandBus::dispatch(GooglePurchaseCommand::instanceFromDto($dto)),
            MarketTypeEnum::APPLE => \CommandBus::dispatch(ApplePurchaseCommand::instanceFromDto($dto)),
            default => throw new \InvalidArgumentException('Unknown market type')
        };

        return PurchaseResultResource::make($result->getResult());
    }
}
