<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.04.24
 * Time: 17:37
 */

namespace App\Library\DeviceBalance\Command;

use App\Library\DeviceBalance\Values\BalanceAmountValue;
use App\Library\DeviceBalance\Values\DeviceIdValue;
use App\Library\DeviceBalance\Values\NoticeValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class UpdateDeviceBalanceCommand extends AbstractCommand
{
    public DeviceIdValue $deviceId;
    public BalanceAmountValue $balanceAmount;

    public ?NoticeValue $notice = null;

    public static function instanceFromPrimitives(string $device_id, float $balance_amount, ?string $notice = null): self
    {
        $command = new self();
        $command->deviceId = new DeviceIdValue($device_id);
        $command->balanceAmount = new BalanceAmountValue($balance_amount);

        if ($notice) {
            $command->notice = new NoticeValue($notice);
        }

        return $command;
    }
}
