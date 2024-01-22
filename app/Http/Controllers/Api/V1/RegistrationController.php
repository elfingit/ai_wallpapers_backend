<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\AddRequest;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use App\Library\Registration\Results\RegistrationResult;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class RegistrationController extends Controller
{
    /**
     * @api {post} /api/v1/registration User registration
     * @apiName Registration
     * @apiGroup Auth
     * @apiDescription Endpoint for registration
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     *
     * @apiBody {String} email User email
     * @apiBody {String} password User password
     * @apiBody {String} password_confirmation
     * @apiBody {String} device_id Device id
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *  }
     *
     * @apiErrorExample {json} Validation-Error:
     *   HTTP/1.1 422
     *   {
     *       "message": "The email field is required. (and 2 more errors)",
     *       "errors": {
     *           "errors": {
     *               "email": [
     *                   "The email field is required."
     *               ],
     *               "password": [
     *                   "The password field is required."
     *               ],
     *              "device_id": [
     *                  "The device id field is required."
     *             ]
     *       }
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "message": "Registration successful",
     *      "user_id": 6,
     *      "user_role": "user"
     *  }
     */
    public function store(AddRequest $request)
    {
        $dto = $request->getDto();

        $command = CreateRegistrationCommand::createFromDto($dto);
        /** @var RegistrationResult $result */
        $result = \CommandBus::dispatch($command);

        $command = CreateUserDeviceCommand::createFromPrimitive(
            Uuid::uuid7()->toString(),
            $request->ip() ?? 'localhost',
            $request->userAgent(),
            $result->getResult()->id
        );

        \CommandBus::dispatch($command);

        return response()->json([
            'message' => 'Registration successful',
            'user_id' => $result->getResult()->id,
            'user_role' => $result->getResult()->role->title_slug,
        ]);
    }
}
