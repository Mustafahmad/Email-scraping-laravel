<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ScrapingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*D:\Laravel\EmailParsing\app\Http\Controllers\Api\ApiController.php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/scrap',[ScrapingController::class, 'index']);
