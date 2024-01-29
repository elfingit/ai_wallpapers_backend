<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(
    [
        'prefix' => 'v1',
        'namespace' => 'Api\V1',
    ],
    function () {
        Route::post('/registration', [RegistrationController::class, 'store']);
        Route::post('/auth', [AuthController::class, 'store']);

        Route::group(
            [
                'middleware' => 'auth:sanctum',
            ],
            function () {
                Route::post('/gallery', [GalleryController::class, 'store']);
                Route::get('/gallery', [GalleryController::class, 'index']);
                Route::patch('/gallery/{pic}', [GalleryController::class, 'update'])
                     ->where('pic', '[0-9]+');
                Route::get('/gallery/{pic}/edit', [GalleryController::class, 'edit'])
                     ->where('pic', '[0-9]+');
                Route::get('/gallery/{pic}/thumbnail', [GalleryController::class, 'thumbnail'])
                    ->name('gallery.thumbnail')
                    ->where('pic', '[0-9]+');
                Route::get('/gallery/{pic}/download', [GalleryController::class, 'download'])
                     ->name('gallery.download')
                     ->where('pic', '[0-9]+');
            }
        );
    }
);
