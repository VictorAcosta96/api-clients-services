<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//client
Route::get('/clients',[ClientController::class,'index']);
Route::post('/clients',[ClientController::class,'store']);
Route::get('/clients/{client}',[ClientController::class,'show']);
Route::put('/clients/{client}',[ClientController::class,'update']);
Route::delete('/clients/{client}',[ClientController::class,'destroy']);

//service
Route::get('/services',[ServiceController::class,'index']);
Route::post('/services',[ServiceController::class,'store']);
Route::get('/services/{service}',[ServiceController::class,'show']);
Route::put('/services/{service}',[ServiceController::class,'update']);
Route::delete('/services/{service}',[ServiceController::class,'destroy']);



Route::post('/clients/service',[ClientController::class, 'attach']);
Route::post('/clients/service/detach',[ClientController::class, 'detach']);


Route::post('/services/clients',[ServiceController::class,'clients']);