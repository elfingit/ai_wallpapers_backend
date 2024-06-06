<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.06.24
 * Time: 11:02
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\AddRequest;
use App\Library\Category\Commands\CreateCategoryCommand;

class CategoryController extends Controller
{
    public function store(AddRequest $request)
    {
        $command = CreateCategoryCommand::createFromDto($request->getDto());

        \CommandBus::dispatch($command);

        return response()->json(['message' => 'Category created'], 201);
    }
}
