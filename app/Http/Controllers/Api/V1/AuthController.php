<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AddRequest;
use App\Library\Auth\Commands\CreateAuthCommand;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(AddRequest $request)
    {
        $command = CreateAuthCommand::createFromDto($request->getDto());
        $result = \CommandBus::dispatch($command);
    }
}
