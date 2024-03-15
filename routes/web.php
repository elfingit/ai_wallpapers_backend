<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/terms_of_conditions.html', function () {
    return view('terms_of_conditions', [
        'data' => config('terms_of_conditions')
    ]);
});

Route::get('/privacy_policy.html', function () {
    return view('privacy_policy', [
        'data' => config('privacy_policy')
    ]);
});

Route::get('/gal_help.html', function () {
    $locale = \App::getLocale();

    return view( 'en/gal_help', [
        'locale' => $locale
    ]);
});

