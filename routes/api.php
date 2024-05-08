<?php

use Illuminate\Http\Request;
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
Route::post('/register',[\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login',[\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::get('/video',[\App\Http\Controllers\Api\VideoController::class, 'index']);
Route::get('/video/{id}',[\App\Http\Controllers\Api\VideoController::class, 'show']);
Route::get('/getVideo/{video}',[\App\Http\Controllers\Api\VideoController::class, 'getVideo'])->name('video.file');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/logout',[\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/me',[\App\Http\Controllers\Api\AuthController::class, 'user']);

    Route::apiResource('/album',\App\Http\Controllers\Api\AlbumController::class);
    Route::apiResource('/category',\App\Http\Controllers\Api\CategoryController::class);
    Route::post('/video',[\App\Http\Controllers\Api\VideoController::class, 'store']);
    Route::put('/video/{id}',[\App\Http\Controllers\Api\VideoController::class, 'store']);
    Route::delete('/video/{id}',[\App\Http\Controllers\Api\VideoController::class, 'destroy']);

    Route::get('/userAlbums',[\App\Http\Controllers\Api\AlbumController::class, 'userAlbums']);
    Route::post('/addVideoToAlbum',[\App\Http\Controllers\Api\AlbumController::class, 'addVideoToAlbum']);

    Route::get('/userCategories',[\App\Http\Controllers\Api\CategoryController::class, 'userMostFrequentCategories']);

});
