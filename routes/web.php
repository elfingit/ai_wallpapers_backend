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
    $locale = \App::getLocale();
    return view($locale . '/terms_of_conditions');
});

Route::get('/privacy_policy.html', function () {
    $locale = \App::getLocale();
    return view($locale . '/privacy_policy');
});
