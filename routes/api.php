<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\XssSanitization;
use App\Http\Controllers\Api\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["middleware" => XssSanitization::class], function($router) {
    Route::get('/v1/travel-history', [UserController::class, 'travelHistory'])->name('v1/travel_history');   
    Route::get('/v1/travellers-count', [UserController::class, 'travellersCountsByCity'])->name('v1/travel_counts');   
});

