<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BillingController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ContactFormController;
use App\Http\Controllers\Api\V1\DeleteAccountController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\SocialNetworkController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserDeviceController;
use App\Http\Controllers\Api\V1\WallpaperController;
use App\Http\Middleware\AppSignRequestMiddleware;
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
        Route::post('/auth', [AuthController::class, 'store']);
        Route::post('/contact_form', [ContactFormController::class, 'store']);
        Route::post('/user_device', [UserDeviceController::class, 'store'])
            ->middleware(AppSignRequestMiddleware::class);

        Route::group(
            [
                'middleware' => 'auth:device',
            ],
            function () {
                //User registration
                Route::post('/registration', [RegistrationController::class, 'store']);
                Route::post('/registration/social', [SocialNetworkController::class, 'store'])
                     ->middleware(AppSignRequestMiddleware::class);


                //Gallery
                Route::post('/gallery', [GalleryController::class, 'store']);
                Route::get('/gallery', [GalleryController::class, 'index']);
                Route::patch('/gallery/{pic}', [GalleryController::class, 'update'])
                     ->where('pic', '[0-9]+');
                Route::delete('/gallery/{pic}', [GalleryController::class, 'delete'])
                     ->where('pic', '[0-9]+');
                Route::get('/gallery/{pic}/edit', [GalleryController::class, 'edit'])
                     ->where('pic', '[0-9]+');

                Route::get('/gallery/{pic}/refresh', [GalleryController::class, 'refresh'])
                     ->where('pic', '[0-9]+');

                /*Route::get('/gallery/{pic}/thumbnail', [GalleryController::class, 'thumbnail'])
                    ->name('gallery.thumbnail')
                    ->where('pic', '[0-9]+');
                Route::get('/gallery/{pic}/download', [GalleryController::class, 'download'])
                     ->name('gallery.download')
                     ->where('pic', '[0-9]+');
                */

                //Wallpaper
                Route::post('/wallpaper', [WallpaperController::class, 'store']);

                //User
                Route::get('/user/balance', [UserController::class, 'balance']);
                Route::get('/user', [UserController::class, 'index']);
                Route::get('/logout', [AuthController::class, 'logout']);
                Route::delete('/account', [DeleteAccountController::class, 'delete']);

                //Billing
                Route::post('/billing/purchase/{type}', [BillingController::class, 'store'])
                    ->where('type', 'google|apple')
                    ->middleware(AppSignRequestMiddleware::class);

                //Category
                Route::post('/category', [CategoryController::class, 'store']);
                Route::get('/category', [CategoryController::class, 'index']);
                Route::get('/category/meta', [CategoryController::class, 'meta']);
                Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])
                     ->where('category', '[0-9]+');
                Route::patch('/category/{category}', [CategoryController::class, 'update'])
                     ->where('category', '[0-9]+');
            }
        );
    }
);
