<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/discord', [App\Http\Controllers\DiscordController::class, 'login']);

Route::get('/process-oauth', [App\Http\Controllers\DiscordController::class, 'processOauth']);

require __DIR__.'/auth.php';
