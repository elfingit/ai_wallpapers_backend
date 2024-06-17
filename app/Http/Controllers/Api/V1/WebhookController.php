<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 14:45
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Webhook\AppleRequest;
use App\Library\Webhook\Commands\AppleWebhookCommand;

class WebhookController extends Controller
{
    public function apple(AppleRequest $request)
    {
        \Log::info('Apple webhook', $request->all());
        \CommandBus::dispatch(
            AppleWebhookCommand::instanceFromDto($request->getDto())
        );

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
