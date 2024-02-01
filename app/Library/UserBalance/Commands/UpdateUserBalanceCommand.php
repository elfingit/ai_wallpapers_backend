<?php

namespace App\Library\UserBalance\Commands;

use App\Library\UserBalance\Values\BalanceAmountValue;
use App\Library\UserBalance\Values\UserIdValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\UserBalance\Dto\UpdateDto;

class UpdateUserBalanceCommand extends AbstractCommand
{
    public UserIdValue $userId;
    public BalanceAmountValue $balanceAmount;

    public static function instanceFromPrimitives(int $user_id, float $balance_amount): self
    {
        $command = new self();
        $command->userId = new UserIdValue($user_id);
        $command->balanceAmount = new BalanceAmountValue($balance_amount);

        return $command;
    }
}
