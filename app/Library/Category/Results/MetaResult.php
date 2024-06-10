<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 11:54
 */

namespace App\Library\Category\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class MetaResult implements CommandResultContract
{
    public function __construct(private readonly array $meta_data)
    {
    }

    public function getResult(): array
    {
        return $this->meta_data;
    }
}
