<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.06.24
 * Time: 11:39
 */

namespace App\Library\Category\Results;

use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class EditResult implements CommandResultContract
{
    public function __construct(private readonly Category $category)
    {
    }

    public function getResult(): Category
    {
        return $this->category;
    }
}
