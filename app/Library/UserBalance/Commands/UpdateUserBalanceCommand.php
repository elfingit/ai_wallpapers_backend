<?php

namespace App\Library\UserBalance\Commands;

use App\Library\UserBalance\Values\BalanceAmountValue;
use App\Library\UserBalance\Values\NoticeValue;
use App\Library\UserBalance\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class UpdateUserBalanceCommand extends AbstractCommand
{
    public UserIdValue $userId;
    public BalanceAmountValue $balanceAmount;

    public ?NoticeValue $notice = null;

    public static function instanceFromPrimitives(int $user_id, float $balance_amount, ?string $notice = null): self
    {
        $command = new self();
        $command->userId = new UserIdValue($user_id);
        $command->balanceAmount = new BalanceAmountValue($balance_amount);

        if ($notice) {
            $command->notice = new NoticeValue($notice);
        }

        return $command;
    }
}
