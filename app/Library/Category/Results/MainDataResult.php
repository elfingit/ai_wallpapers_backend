<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:53
 */

namespace App\Library\Category\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class MainDataResult implements CommandResultContract
{
    public function __construct(private readonly array $data)
    {
    }

    public function getResult(): array
    {
        return $this->data;
    }
}
