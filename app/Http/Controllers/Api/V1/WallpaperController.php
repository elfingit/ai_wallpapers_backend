<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallpaper\AddRequest;
use App\Library\Wallpaper\Commands\CreateWallpaperCommand;
use Illuminate\Http\Request;

class WallpaperController extends Controller
{
    public function store(AddRequest $request)
    {
        $command = CreateWallpaperCommand::createFromDto($request->getDto(), $request->user()->id);
        $gallery = \CommandBus::dispatch($command);

        dd($gallery);
    }
}
