<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * @see AuthController::class
 * @methodName register
 */
//public
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',[AuthController::class,'logIn']);


});
//private
Route::middleware(['auth:sanctum'])->prefix('v1')->group( function( ) {
    Route::post('logout',[AuthController::class,'logout']);//Route For Logout.
});
//Route::group(['middleware'=>['auth:sanctum']],function (){
//
//});
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    Route::post('/logout',[AuthController::class,'logout']);
//    return $request->user();
//});

