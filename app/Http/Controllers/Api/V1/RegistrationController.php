<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\AddRequest;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use Illuminate\Http\Request;

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
     */
    public function store(AddRequest $request)
    {
        $dto = $request->getDto();

        $command = CreateRegistrationCommand::createFromDto($dto);
        $res = \CommandBus::dispatch($command);

        return response()->json([
            'message' => 'Registration successful',
        ]);
    }
}
