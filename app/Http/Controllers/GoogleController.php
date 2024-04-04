<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleRemoveDataRequest;
use App\Library\PersonalData\Commands\EmailRemoveDataCommand;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function removeData(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('google.remove_data');
    }

    public function sentRemoveData(GoogleRemoveDataRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $command = EmailRemoveDataCommand::instanceFromPrimitive($request->input('email'));
        \CommandBus::dispatch($command);
        return view('google.remove_data_sent');
    }
}
