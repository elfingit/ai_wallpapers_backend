<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 14:57
 */

namespace App\Library\Billing\Commands;

use App\Library\Billing\Dto\ApplePurchaseDto;
use App\Library\Billing\Dto\AppleSubscriptionDto;
use App\Library\Billing\Values\DeviceIdValue;
use App\Library\Billing\Values\ProductAmountValue;
use App\Library\Billing\Values\ProductIdValue;
use App\Library\Billing\Values\PurchaseTokenValue;
use App\Library\Billing\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class ApplePurchaseCommand extends AbstractCommand
{
    public ProductIdValue $productId;
    public PurchaseTokenValue $purchaseToken;

    public ProductAmountValue $productAmount;

    public ?UserIdValue $userId = null;
    public ?DeviceIdValue $deviceId = null;

    static public function instanceFromDto(AppleSubscriptionDto $dto): self
    {
        $command =  new self();
        $command->productId = new ProductIdValue($dto->product_id);
        $command->purchaseToken = new PurchaseTokenValue($dto->purchase_token);
        if (!is_null($dto->user_id)) {
            $command->userId = new UserIdValue($dto->user_id);
        } elseif (!is_null($dto->device_id)) {
            $command->deviceId = new DeviceIdValue($dto->device_id);
        }

        $command->productAmount = new ProductAmountValue($dto->product_amount);

        return $command;
    }
}
