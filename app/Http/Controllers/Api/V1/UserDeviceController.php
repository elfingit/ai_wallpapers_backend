<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDevice\AddRequest;
use Illuminate\Http\Request;

class UserDeviceController extends Controller
{
    public function store(AddRequest $request)
    {
        return response()->json([
            'message' => 'Device registration',
        ]);
    }
}
