<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getUserList', [SampleController::class, 'getUserList']);
Route::get('getUserById', [SampleController::class, 'getUserById']);
Route::post('createUser', [SampleController::class, 'createUser']);
Route::post('updateUser', [SampleController::class, 'updateUser']);
Route::post('deleteUser', [SampleController::class, 'deleteUser']);
