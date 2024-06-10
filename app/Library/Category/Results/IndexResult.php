<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.06.24
 * Time: 14:27
 */

namespace App\Library\Category\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexResult implements CommandResultContract
{
    public function __construct(private readonly LengthAwarePaginator $paginator)
    {
    }

    public function getResult(): mixed
    {
        return $this->paginator;
    }
}
