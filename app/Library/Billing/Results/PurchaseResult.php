<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 15:42
 */

namespace App\Library\Billing\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

final class PurchaseResult implements CommandResultContract
{
    public function __construct(
        readonly private bool $success,
        readonly private int $amount = 0,
        readonly private ?string $warn_code = null
    ) {
    }

    public function getResult(): array
    {
        $data = [
            'success' => $this->success,
            'amount' => $this->amount,
        ];

        if (!is_null($this->warn_code)) {
            $data['warn_code'] = $this->warn_code;
        }

        return $data;
    }
}
