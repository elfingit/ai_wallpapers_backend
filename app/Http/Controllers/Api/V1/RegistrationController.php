<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\AddRequest;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(AddRequest $request)
    {
        $dto = $request->getDto();

        $command = CreateRegistrationCommand::createFromDto($dto);
        $res = \CommandBus::dispatch($command);

        return response()->json([
            'message' => 'Registration successful',
        ]);
    }
}
