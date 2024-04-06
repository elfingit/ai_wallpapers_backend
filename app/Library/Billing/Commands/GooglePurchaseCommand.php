<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 11:20
 */

namespace App\Library\Billing\Commands;

use App\Library\Billing\Dto\GooglePurchaseDto;
use App\Library\Billing\Values\ProductIdValue;
use App\Library\Billing\Values\PurchaseTokenValue;
use App\Library\Billing\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GooglePurchaseCommand extends AbstractCommand
{
    public ProductIdValue $productId;
    public PurchaseTokenValue $purchaseToken;

    public UserIdValue $userId;

    static public function instanceFromDto(GooglePurchaseDto $dto): self
    {
        $command =  new self();
        $command->productId = new ProductIdValue($dto->product_id);
        $command->purchaseToken = new PurchaseTokenValue($dto->purchase_token);
        $command->userId = new UserIdValue($dto->user_id);

        return $command;
    }
}
