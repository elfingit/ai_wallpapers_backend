<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDevice\AddRequest;
use App\Library\DeviceToken\Commands\CreateDeviceTokenCommand;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserDeviceController extends Controller
{
    public function store(AddRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $command = CreateUserDeviceCommand::createFromPrimitive(
            $dto->device_id,
            $request->ip() ?? 'localhost',
            $request->userAgent() ?? 'unknown'
        );
        $result = \CommandBus::dispatch($command);

        if (!$result) {
            return response()->json(status: 500);
        }

        $tokenCommand = CreateDeviceTokenCommand::instanceFromPrimitive($result->getResult()->uuid);
        $tokenResult = \CommandBus::dispatch($tokenCommand);

        if (!$tokenResult) {
            return response()->json(status: 500);
        }

        return response()->json([
            'token' => $tokenResult->getResult()
        ]);
    }
}
