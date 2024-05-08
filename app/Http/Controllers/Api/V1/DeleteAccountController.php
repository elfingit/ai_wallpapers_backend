<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 8.05.24
 * Time: 07:29
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccount\DeleteRequest;
use App\Library\PersonalData\Commands\DeleteAccountCommand;
use Illuminate\Http\JsonResponse;

class DeleteAccountController extends Controller
{
    public function delete(DeleteRequest $request): JsonResponse
    {
        \CommandBus::dispatch(
            DeleteAccountCommand::instanceFromPrimitive(
                $request->user()->id
            )
        );

        return response()->json([
            'message' => 'Account deleted'
        ]);
    }
}
