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
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\Gallery\EditRequest;
use App\Http\Resources\Category\EditResource;
use App\Library\Category\Commands\CreateCategoryCommand;
use App\Library\Category\Commands\EditCategoryCommand;
use App\Library\Category\Commands\UpdateCategoryCommand;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(AddRequest $request)
    {
        $command = CreateCategoryCommand::createFromDto($request->getDto());

        \CommandBus::dispatch($command);

        return response()->json(['message' => 'Category created'], 201);
    }

    public function edit(EditRequest $request, Category $category)
    {
        $result = \CommandBus::dispatch(EditCategoryCommand::instanceFromPrimitive($category->id));

        return EditResource::make($result->getResult());
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $dto = $request->getDto();
        $dto->id = $category->id;

        $command = UpdateCategoryCommand::createFromDto($dto);

        \CommandBus::dispatch($command);

        return response()->json(['message' => 'Category updated'], 200);
    }
}
