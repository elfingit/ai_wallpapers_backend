<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactForm\StoreRequest;
use App\Library\ContactForm\Commands\SendMessageCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $command = SendMessageCommand::instanceFromDto($dto);
        \CommandBus::dispatch($command);

        return response()->json(['message' => 'Message sent'], 201);
    }
}
