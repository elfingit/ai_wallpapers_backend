<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInNetwork\IncomeRequest;
use App\Library\Auth\Commands\AppleSignInCommand;
use App\Library\Auth\Commands\FacebookSignInCommand;
use App\Library\Auth\Commands\GoogleSignInCommand;
use App\Library\Auth\Dto\AppleDto;
use App\Library\Auth\Dto\FacebookDto;
use App\Library\Auth\Dto\GoogleDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialNetworkController extends Controller
{
    public function store(IncomeRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $dto->ip = $request->ip() ?? '';
        $dto->user_agent = $request->userAgent() ?? '';

        $result = match (true) {
            $dto instanceof FacebookDto => \CommandBus::dispatch(FacebookSignInCommand::instanceFromDto($dto)),
            $dto instanceof GoogleDto => \CommandBus::dispatch(GoogleSignInCommand::instanceFromDto($dto)),
            $dto instanceof AppleDto => \CommandBus::dispatch(AppleSignInCommand::instanceFromDto($dto)),
            default => throw new \InvalidArgumentException('Unknown network type'),
        };

        if (is_null($result)) {
            abort(401);
        }

        return response()->json($result->getResult());
    }
}