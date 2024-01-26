<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 12:01
 */

namespace App\Library\Gallery\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexResult implements CommandResultContract
{
    public function __construct(private readonly LengthAwarePaginator $paginator)
    {

    }

    public function getResult(): LengthAwarePaginator
    {
        return $this->paginator;
    }

}
