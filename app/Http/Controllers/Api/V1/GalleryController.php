<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\AddRequest;
use App\Library\Gallery\Commands\CreateGalleryCommand;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function store(AddRequest $request)
    {
        $command = CreateGalleryCommand::createFromDto($request->getDto());
        \CommandBus::dispatch($command);
    }
}
