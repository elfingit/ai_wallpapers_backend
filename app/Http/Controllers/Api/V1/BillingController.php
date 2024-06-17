<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\PurchaseRequest;
use App\Http\Requests\Billing\SubscriptionRequest;
use App\Http\Resources\User\PurchaseResultResource;
use App\Library\Billing\Commands\ApplePurchaseCommand;
use App\Library\Billing\Commands\AppleSubscriptionCommand;
use App\Library\Billing\Commands\GooglePurchaseCommand;
use App\Library\Billing\Enums\MarketTypeEnum;
use App\Library\Core\Logger\LoggerChannel;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingController extends Controller
{
    public function store(PurchaseRequest $request, string $type): JsonResource
    {
        $dto = $request->getDto();
        $owner = $request->user();

        if ($owner instanceof User) {
            $dto->user_id = $owner->id;
        } elseif ($owner instanceof UserDevice) {
            $dto->device_id = $owner->uuid;
        }

        $dto->product_amount = config('products.one_time.' . $dto->product_id);

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

    public function subscription(SubscriptionRequest $request, string $type)
    {
        $dto = $request->getDto();
        $owner = $request->user();

        if ($owner instanceof User) {
            $dto->user_id = $owner->id;
        } elseif ($owner instanceof UserDevice) {
            $dto->device_id = $owner->uuid;
        }

        $dto->product_amount = config('products.subscriptions.' . $dto->product_id);

        $market = MarketTypeEnum::tryFrom($type);

        $result = match ($market) {
            MarketTypeEnum::APPLE => \CommandBus::dispatch(AppleSubscriptionCommand::instanceFromDto($dto)),
            default => throw new \InvalidArgumentException('Unknown market type')
        };

        return PurchaseResultResource::make($result->getResult());
    }
}
