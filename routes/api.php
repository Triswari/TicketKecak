<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddTicketsController;
use App\Http\Controllers\AdditionalsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk mendapatkan harga tiket
Route::get('/tickets/{id}', [AddTicketsController::class, 'getTicketPrice']);

// Route untuk mendapatkan harga additioonal
Route::get('/additionals/{id}', [AdditionalsController::class, 'getAdditionalPrice']);
