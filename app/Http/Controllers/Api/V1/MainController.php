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
use App\Http\Requests\Main\ProfileRequest;
use App\Http\Resources\MainData\MainDataResource;
use App\Library\Category\Commands\GetMainDataCommand;
use App\Library\User\Commands\GetUserProfileCommand;
use App\Library\UserDevice\Commands\GetDeviceProfileCommand;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class MainController extends Controller
{
    public function index(IndexRequest $request): JsonResource
    {
        $command = GetMainDataCommand::instanceFromDto($request->getDto());
        $result = \CommandBus::dispatch($command);

        return MainDataResource::make($result->getResult());
    }

    public function profile(ProfileRequest $request): JsonResponse
    {
        $result = match (get_class($request->user())) {
            UserDevice::class => \CommandBus::dispatch(
                GetDeviceProfileCommand::instanceFromPrimitives($request->user()->uuid)
            )->getResult(),
            User::class => \CommandBus::dispatch(
                GetUserProfileCommand::instanceFromPrimitives($request->user()->id)
            )->getResult(),
        };

        return response()->json($result);
    }
}
