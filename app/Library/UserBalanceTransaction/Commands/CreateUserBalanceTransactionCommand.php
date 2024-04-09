<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.02.24
 * Time: 10:01
 */

namespace App\Library\UserBalanceTransaction\Commands;

use App\Library\UserBalanceTransaction\Values\BalanceAmountValue;
use App\Library\UserBalanceTransaction\Values\BalanceIdValue;
use App\Library\UserBalanceTransaction\Values\NoticeValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class CreateUserBalanceTransactionCommand extends AbstractCommand
{
    public BalanceIdValue $balanceId;
    public BalanceAmountValue $amount;
    public ?NoticeValue $notice = null;

    public static function instanceFromPrimitives(
        int $balance_id,
        float $amount,
        ?string $notice = null): self {

        $command = new self();

        $command->balanceId = new BalanceIdValue($balance_id);
        $command->amount = new BalanceAmountValue($amount);

        if ($notice) {
            $command->notice = new NoticeValue($notice);
        }

        return $command;
    }
}
