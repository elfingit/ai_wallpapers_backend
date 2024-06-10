<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:13
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\IndexRequest;
use App\Http\Resources\MainData\MainDataResource;
use App\Library\Category\Commands\GetMainDataCommand;

class MainController extends Controller
{
    public function index(IndexRequest $request)
    {
        $command = GetMainDataCommand::instanceFromDto($request->getDto());
        $result = \CommandBus::dispatch($command);

        return MainDataResource::make($result->getResult());
    }
}
