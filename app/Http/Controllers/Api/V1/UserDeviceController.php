<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDevice\AddRequest;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use Illuminate\Http\Request;

class UserDeviceController extends Controller
{
    public function store(AddRequest $request)
    {
        $dto = $request->getDto();
        $command = CreateUserDeviceCommand::createFromPrimitive(
            $dto->device_id,
            $request->ip() ?? 'localhost',
            $request->userAgent() ?? 'unknown'
        );
        \CommandBus::dispatch($command);

        return response()->json(status: 201);
    }
}
