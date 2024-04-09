<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.02.24
 * Time: 12:19
 */

namespace App\Library\User\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Pagination\LengthAwarePaginator;

class ListResult implements CommandResultContract
{
    public function __construct(private readonly LengthAwarePaginator $paginator)
    {
    }
    public function getResult(): LengthAwarePaginator
    {
        return $this->paginator;
    }
}
