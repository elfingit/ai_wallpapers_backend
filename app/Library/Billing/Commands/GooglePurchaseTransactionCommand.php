<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:16
 */

namespace App\Library\Billing\Commands;

use App\Library\Billing\Values\GoogleAcknowledgementStateValue;
use App\Library\Billing\Values\GoogleConsumptionStateValue;
use App\Library\Billing\Values\GoogleOrderIdValue;
use App\Library\Billing\Values\GooglePurchaseStateValue;
use App\Library\Billing\Values\GooglePurchaseTypeValue;
use App\Library\Billing\Values\GoogleRegionCodeValue;
use App\Library\Billing\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GooglePurchaseTransactionCommand extends AbstractCommand
{
    public GoogleOrderIdValue $googleOrderId;
    public GooglePurchaseStateValue $purchaseState;
    public GoogleConsumptionStateValue $consumptionState;
    public GooglePurchaseTypeValue $purchaseType;
    public GoogleAcknowledgementStateValue $acknowledgementState;
    public GoogleRegionCodeValue $regionCode;
    public UserIdValue $userId;

    static public function instanceFromArray(array $data): self
    {
        $command = new self();
        $command->googleOrderId = new GoogleOrderIdValue($data['orderId']);
        $command->purchaseState = new GooglePurchaseStateValue($data['purchaseState']);
        $command->consumptionState = new GoogleConsumptionStateValue($data['consumptionState']);
        $command->purchaseType = new GooglePurchaseTypeValue($data['purchaseType']);
        $command->acknowledgementState = new GoogleAcknowledgementStateValue($data['acknowledgementState']);
        $command->regionCode = new GoogleRegionCodeValue($data['regionCode']);
        $command->userId = new UserIdValue($data['user_id']);

        return $command;
    }
}
