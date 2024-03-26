<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.03.24
 * Time: 08:36
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class AppSignRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->input('_signature');

        if (is_null($signature)) {
            return response()->json(['error' => 'Bad request'], 400);
        }

        $input = $request->all();

        $string = '';

        foreach ($input as $key => $value) {
            if ($key == '_signature') continue;

            $string .= $key . ':' . $value;
        }

        $hash = hash_hmac('sha256', $string, config('app.client_signature'));

        if ($hash != $signature) {
            return response()->json(['error' => 'Bad request'], 400);
        }

        return $next($request);
    }
}
