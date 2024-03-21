<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInNetwork\IncomeRequest;
use App\Library\Auth\Commands\FacebookSignInCommand;
use App\Library\Auth\Commands\GoogleSignInCommand;
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
            default => throw new \InvalidArgumentException('Unknown network type'),
        };

        return response()->json($result->getResult());
    }
}
